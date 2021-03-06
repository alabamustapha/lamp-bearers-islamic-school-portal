<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\ClassroomSubject;
use App\Comment;
use App\Country;
use App\Level;
use App\Psychomotor;
use App\Result;
use App\Role;
use App\Session;
use App\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\Teacher;
use App\Http\Requests;
use App\Events\TeacherRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    public function index(){

        $teachers = Teacher::all();
        return view('teacher.index')->with(['teachers' => $teachers]);

    }

    public function show($id){

        $teacher = Teacher::with('classrooms', 'classroom_subjects', 'levels')->find($id);

        return view('admin.teacher')->with('teacher', $teacher);
    }

    public function create(){

        $countries = Country::all();

        $staff_id = generate_staff_id();
        return view('teacher.create')->with(['countries' => $countries, 'staff_id' => $staff_id]);
    }

    public function store(Requests\StoreNewTeacher $request){

        //dd($request);

        $user = new User;

        $user->username = $request->staff_id;

        $user->password = bcrypt($request->surname);

        $user->save();

        $user->addRole(Role::where('name', '=', 'teacher')->first()->id);


        $teacher = Teacher::create([
            'title'         => $request->title,
            'name'          => $request->surname . ' ' . $request->first_name . ' ' . $request->middle_name,
            'user_id'       => $user->id,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'dob'           => Carbon::createFromFormat('m/d/Y', $request->dob),
            'date_employed' => Carbon::createFromFormat('m/d/Y', $request->date_employed),
            'staff_id'      => $request->staff_id,
            'address'       => $request->address,
            'marital_status'=> $request->marital_status,
            'salary'        => $request->salary,
            'description'   => $request->description,
            'sex'           => $request->sex,
            'country_id'    => $request->country_id,
            'state_id'      => $request->state_id,
            'lga_id'        => $request->lga_id
        ]);

        //dd($request->file('image')->isValid());

        // event(new TeacherRegistration($teacher, $user));


        if ($request->hasFile('image')) {

            if ($request->file('image')->isValid()) {
                $path = $request->image->store('public/images/teacher/profile');
                $teacher->image = str_replace('public/', null, $path);
                $teacher->save();

                return back()->with('message', 'Teacher record created successfully');
            }
        }


        return back()->with('message', 'Teacher record created successfully, upload image again');

    }

    public function dashboard(){

        $teacher = Teacher::with('classrooms', 'classroom_subjects')->where('staff_id', '=', Auth::user()->username)->first();

        return view('teacher.dashboard', compact('teacher'));
    }

    public function showClassroom($classroom_id){
        $classroom = Classroom::with(['students', 'teacher', 'level', 'promoting_and_repeating_students'])->findOrFail($classroom_id);
        $classrooms = Classroom::all();

        $students = $classroom->active_students();
        $promoted_students = $classroom->promoted_students();
        $promoting_students = $classroom->promoting_students();
        $repeated_students = $classroom->repeated_students();
        $repeating_students = $classroom->repeating_students();

        $highest_level = Level::all()->max('rank');

        //dd($students);

        return view('teacher.classroom')
            ->with('classroom', $classroom)
            ->with('teacher', $classroom->teacher)
            ->with('students', $students)
            ->with('promoted_students', $promoted_students)
            ->with('promoting_students', $promoting_students)
            ->with('repeated_students', $repeated_students)
            ->with('repeating_students', $repeating_students)
            ->with('highest_level', $highest_level)
            ->with('classrooms', $classrooms);
    }


    public function showStudent($classroom_id, $student_id){

        $classroom = Classroom::with(['students', 'teacher'])->findOrFail($classroom_id);
        $classrooms = Classroom::all();
        $student = Student::with('results')->findOrFail($student_id);

        return view('teacher.student')
            ->with('classroom', $classroom)
            ->with('classrooms', $classrooms)
            ->with('teacher', $classroom->teacher)
            ->with('student', $student);
    }

    public function showSubject($classroom_id, $subject_id){

        $classroom = Classroom::with(['results', 'students'])->findOrFail($classroom_id);

        $students = $classroom->students()->where('status', '=', 'active')->get();

        $subject = ClassroomSubject::where('subject_id', '=', $subject_id)->where('classroom_id', '=', $classroom_id)->first();


        $session = Session::where('status', 'active')->first();

        if(isset($session) && !is_null($session) && $session->status == 'active'){

            $subject_results = Result::where('subject_id', '=', $subject_id)
                ->where('classroom_id', '=', $classroom_id)
                ->where('session_id', '=', $session->id)->get();
        }else{
            $subject_results = null;
        }

        $teacher =  Auth::user()->teacher;

        return view('teacher.subject')
            ->with('classroom', $classroom)
            ->with('teacher', $teacher)
            ->with('subject', $subject)
            ->with('subject_results', $subject_results)
            ->with('students', $students);
    }

    public function showTeacherClassroom($classroom_id){
        $classroom = Classroom::with('students', 'subjects')->firstOrFail($classroom_id);
        $classrooms = Classroom::all();
        $students = $classroom->students()->where('status', '=', 'active');


        return view('teacher.classroom')->with('classroom', $classroom)
            ->with('classrooms', $classrooms)
            ->with('students', $students);
    }


    public function storeStudentSubjectScoreExcel(Requests\TeacherSubjectClassroomTermResults $request, $classroom_id, $subject_id){


        $excel_results = Excel::load($request->students_term_results)->get();

        $error_counts = 0;


        foreach($excel_results as $row){
            $student = Student::where('admin_number', $row->admin_number)->first();

            $result = Result::where('student_id', $student->id)->where('session_id', $request->session_id)->where('classroom_id', $request->classroom_id)->where('subject_id', $subject_id)->where('term', $request->term)->first();


            if(isset($result) || !is_null($result) ){


                if((int)$row->ca1 <= 20 && (int)$row->ca2 <= 20 && (int)$row->exam <= 60){
                    $result->first_ca = (int)$row->ca1;
                    $result->second_ca = (int)$row->ca2;
                    $result->exam = (int)$row->exam;
                    $result->save();

                }else{
                    $error_counts++;
                }
            }else{

                if((int)$row->ca1 <= 20 && (int)$row->ca2 <= 20 && (int)$row->exam <= 60) {
                    $result = Result::create([
                        'session_id' => $request->session_id,
                        'classroom_id' => $request->classroom_id,
                        'subject_id' => $request->subject_id,
                        'student_id' => $student->id,
                        'teacher_id' => $request->teacher_id,
                        'term' => $request->term,
                        'first_ca' => (int)$row->ca1,
                        'second_ca' => (int)$row->ca2,
                        'exam' => (int)$row->exam,
                    ]);
                }

            }


        }

        $message = $error_counts > 0 ? 'Student results updated, ' . $error_counts . ' scores not updated' : 'Student results updated successfully';

        return back()->with('message', $message);

    }
    public function storeStudentSubjectScore(Requests\StoreStudentSubjectScore $request, $classroom_id, $subject_id, $student_id){

        $result = Result::where('classroom_id', '=', $request->classroom_id)
                        ->where('subject_id', '=', $request->subject_id)
                        ->where('student_id', '=', $request->student_id)
                        ->where('term', '=', $request->term)
                        ->where('session_id', '=', $request->session_id)->get()->first();


        if(!isset($result) || is_null($result)){
            $result = Result::create([
                'session_id' => $request->session_id,
                'classroom_id' => $request->classroom_id,
                'subject_id' => $request->subject_id,
                'student_id' => $request->student_id,
                'teacher_id' => $request->teacher_id,
                'term' => $request->term,
                'first_ca' => (int)$request->first_ca,
                'second_ca' => (int)$request->second_ca,
                'exam' => (int)$request->exam,
            ]);
        }else{
            $result->first_ca = (int)$request->first_ca;
            $result->second_ca = (int)$request->second_ca;
            $result->exam = (int)$request->exam;
            $result->save();
        }

        $score = [];
        $score['first_ca'] = $result->first_ca;
        $score['second_ca'] = $result->second_ca;
        $score['exam'] = $result->exam;
        $score['total'] = $result->total();
        $score['grade'] = $result->grade();
        $score['position'] = $result->position();

        return $score;
    }


    public function update(Request $request, $id){

        $teacher = Teacher::find($id);

        $teacher->salary = $request->salary;
        $teacher->marital_status = $request->marital_status;
        $teacher->address = $request->address;

        $teacher->save();

        return back()->with('message', 'teacher record updated successfully');

    }


    public function promoteStudent(Requests\PromoteStudent $request, $classroom_id, $student_id){

        $student = Student::find($student_id);

        if($student->status == 'active'){
            $student->previous_classroom_id = $student->classroom_id;
            $student->classroom_id = $request->promoted_to_classroom_id;
            $student->status = 'promoting';

            $student->save();
        }else{
            return back()->with('message', 'Students cant be promoted');
        }


        return back()->with('message', 'Students promoted successfully');

    }

    public function promoteAllStudent(Requests\PromoteAllStudent $request, $classroom_id){

        Student::where('classroom_id', '=', $classroom_id)->where('status', '=', 'active')->update([
            'previous_classroom_id' => $classroom_id,
            'classroom_id' => $request->promoted_to_classroom_id,
            'status' => 'promoting'
        ]);

        return back()->with('message', 'Students promoted successfully');
    }



    public function repeatStudent(Requests\RepeatStudent $request, $classroom_id, $student_id){

        $student = Student::find($student_id);

        if($student->status == 'active'){
            $student->previous_classroom_id = $classroom_id;
            $student->classroom_id = $request->repeated_to_classroom_id;
            $student->status = 'repeating';

            $student->save();
        }else{
            return back()->with('message', 'Students cant be repeated');
        }


        return back()->with('message', 'Students repeated successfully');

    }


    public function graduateStudent(Requests\GraduateStudent $request, $classroom_id, $student_id){

        $student = Student::find($student_id);


        if($student->status == 'active'){
            $student->previous_classroom_id = $classroom_id;
            $student->classroom_id = null;
            $student->status = 'graduating';

            $student->save();
        }else{
            return back()->with('message', 'Student cant be on the list');
        }


        return back()->with('message', 'Student put on graduate list successfully');

    }


    public function graduateAllStudent(Requests\GraduateStudents $request, $classroom_id){

        Student::where('classroom_id', '=', $classroom_id)->where('status', '=', 'active')->update([
            'previous_classroom_id' => $classroom_id,
            'classroom_id' => null,
            'status' => 'graduating'
        ]);

        return back()->with('message', 'Students added to graduate list successfully');
    }

    public function repeatAllStudent(Requests\RepeatAllStudent $request, $classroom_id){

        Student::where('classroom_id', '=', $classroom_id)->where('status', '=', 'active')->update([
            'previous_classroom_id' => $classroom_id,
            'classroom_id' => $request->repeated_to_classroom_id,
            'status' => 'repeating'
        ]);

        return back()->with('message', 'Students repeated successfully');
    }

    public function uploadClassroomCommentsExcel(Requests\UploadClassroomCommentsExcel $request, $classroom_id){

        $comments_count = 0;
        $errors_count = 0;
        $updates_count = 0;
        if ($request->hasFile('comments_physchomotor')) {

            if ($request->file('comments_physchomotor')->isValid()) {

                if($request->type == 'comments') {
                    $comments = Excel::load($request->comments_physchomotor)->get();

                    foreach($comments as $excel_comment){
                        $student = Student::where('admin_number', $excel_comment->admin_no)->first();

                        if($student && !is_null($student) && $student->classroom->id == $classroom_id){

                            $comment = Comment::where('student_id', $student->id)
                                ->where('classroom_id', $classroom_id)
                                ->where('session_id', $request->session_id)
                                ->where('term', $request->term)->first();

                            if($comment && !is_null($comment)){
                                if($excel_comment->comment != null) {
                                    $comment->body = $excel_comment->comment;
                                    $comment->save();
                                    $updates_count++;
                                }
                            }else{
                                if($excel_comment->comment != null) {
                                    Comment::create([
                                        'student_id' => $student->id,
                                        'body' => $excel_comment->comment,
                                        'classroom_id' => $classroom_id,
                                        'session_id' => $request->session_id,
                                        'teacher_id' => $request->teacher_id,
                                        'term' => $request->term
                                    ]);
                                }

                                $comments_count++;
                            }


                        }

                    }
                }

                if($request->type == 'psychomotors'){
                    $psychomotors = Excel::load($request->comments_physchomotor)->get();

                    foreach($psychomotors as $excel_psychomotor){
                        $student = Student::where('admin_number', $excel_psychomotor->admin_no)->first();

                        if($student && !is_null($student) && $student->classroom->id == $classroom_id){

                            $psychomotor = Psychomotor::where('student_id', $student->id)
                                ->where('classroom_id', $classroom_id)
                                ->where('session_id', $request->session_id)
                                ->where('term', $request->term)->first();

                            if($psychomotor && !is_null($psychomotor)){

                                    $psychomotor->handwriting           = $excel_psychomotor->handwriting;
                                    $psychomotor->drawing_painting      = $excel_psychomotor->drawing_painting;
                                    $psychomotor->games_sports          = $excel_psychomotor->games_sports;
                                    $psychomotor->computer_appreciation = $excel_psychomotor->computer_appreciation;
                                    $psychomotor->recitation_skills     = $excel_psychomotor->recitation_skills;
                                    $psychomotor->punctuality           = $excel_psychomotor->punctuality;
                                    $psychomotor->neatness              = $excel_psychomotor->neatness;
                                    $psychomotor->politeness            = $excel_psychomotor->politeness;
                                    $psychomotor->cooperation           = $excel_psychomotor->cooperation;
                                    $psychomotor->leadership            = $excel_psychomotor->leadership;
                                    $psychomotor->emotional_stability   = $excel_psychomotor->emotional_stability;
                                    $psychomotor->health                = $excel_psychomotor->health;
                                    $psychomotor->attitude_to_work      = $excel_psychomotor->attitude_to_work;
                                    $psychomotor->attentiveness         = $excel_psychomotor->attentiveness;

                                    $psychomotor->save();

                            }else{

                                    Psychomotor::create([
                                        'student_id'            => $student->id,
                                        'classroom_id'          => $classroom_id,
                                        'session_id'            => $request->session_id,
                                        'teacher_id'            => $request->teacher_id,
                                        'term'                  => $request->term,
                                        'handwriting'           => $excel_psychomotor->handwriting,
                                        'drawing_painting'      => $excel_psychomotor->drawing_painting,
                                        'games_sports'          => $excel_psychomotor->games_sports,
                                        'computer_appreciation' => $excel_psychomotor->computer_appreciation,
                                        'recitation_skills'     => $excel_psychomotor->recitation_skills,
                                        'punctuality'           => $excel_psychomotor->punctuality,
                                        'neatness'              => $excel_psychomotor->neatness,
                                        'politeness'            => $excel_psychomotor->politeness,
                                        'cooperation'           => $excel_psychomotor->cooperation,
                                        'leadership'            => $excel_psychomotor->leadership,
                                        'emotional_stability'   => $excel_psychomotor->emotional_stability,
                                        'health'                => $excel_psychomotor->health,
                                        'attitude_to_work'      => $excel_psychomotor->attitude_to_work,
                                        'attentiveness'         => $excel_psychomotor->attentiveness
                                    ]);
                            }


                        }

                    }
                }

            }
        }

        return back()->with('message', $comments_count . ' Comments added, ' . $updates_count . ' Comments updated ,' . $errors_count . ' Errors encountered');
    }

    public function getClassroomPsychomotorTemplate(Request $request, $classroom_id){

        $classroom = Classroom::with('students')->where('id', '=', $classroom_id)->first();


        \Excel::create($classroom->name . "Psychomotor", function($excel) use ($classroom){

            $excel->sheet('Psychomotor', function($sheet) use ($classroom) {

                $row_number = 2;

                $sheet->row(1, array(
                    'Admin NO.', 'Name', 'Handwriting', 'Drawing & Painting', 'Games & Sports', 'Computer Appreciation', 'Recitation Skills', 'Punctuality', 'Neatness', 'Politeness', 'Cooperation',
                    'Leadership',	'Emotional stability',	'Health', 'Attitude To Work',	'Attentiveness'
                ));

                foreach($classroom->students as $student){
                    if($student->status == 'active') {
                        $sheet->row($row_number++, array(
                            $student->admin_number, $student->name
                        ));
                    }
                }



            });

        })->export("xlsx");
    }

    public function getClassroomCommentTemplate(Request $request, $classroom_id){

        $classroom = Classroom::with('students')->where('id', '=', $classroom_id)->first();



        \Excel::create($classroom->name . "Comments", function($excel) use ($classroom){

            $excel->sheet('Comments', function($sheet) use ($classroom) {

                $row_number = 2;

                $sheet->row(1, array(
                    'Admin NO.', 'Name', 'Comment'
                ));

                foreach($classroom->students as $student){
                    if($student->status == 'active') {
                        $sheet->row($row_number++, array(
                            $student->admin_number, $student->name
                        ));
                    }
                }



            });

        })->export("xlsx");
    }
}
