<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Country;
use App\Guardian;
use App\House;
use App\Result;
use App\Session;
use App\Student;
use App\Subject;
use App\Teacher;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class AdminController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        //$this->middleware('admin');
    }
    public function dashboard(){
        $total_male_students = Student::whereIn('status', ['active', 'repeating', 'repeated', 'promoting', 'promoted', 'graduating'])->where('sex', '=', 'Male')->count();
        $total_female_students = Student::whereIn('status', ['active', 'repeating', 'repeated', 'promoting', 'promoted', 'graduating'])->where('sex', '=', 'Female')->count();
        $total_students = $total_female_students + $total_male_students;


        $total_graduated_male_students = Student::where('status', '=', 'graduated')->where('sex', '=', 'Male')->count();
        $total_graduated_female_students = Student::where('status', '=', 'graduated')->where('sex', '=', 'Female')->count();
        $total_graduated_students = $total_graduated_male_students + $total_graduated_female_students;

        $total_male_teachers = Teacher::where('status', '=', 'active')->where('sex', '=', 'Male')->count();
        $total_female_teachers = Teacher::where('status', '=', 'active')->where('sex', '=', 'Female')->count();
        $total_teachers = $total_female_teachers + $total_male_teachers;

        return view('admin.dashboard')->with('total_male_students', $total_male_students)
            ->with('total_female_students', $total_female_students)
            ->with('total_students', $total_students)
            ->with('total_male_teachers', $total_male_teachers)
            ->with('total_graduated_male_students', $total_graduated_male_students)
            ->with('total_graduated_students', $total_graduated_students)
            ->with('total_graduated_female_students', $total_graduated_female_students)
            ->with('total_female_teachers', $total_female_teachers)->with('total_teachers', $total_teachers);
    }

    public function deleteResult(Request $request, $result_id){

        $result = Result::find($result_id);
        if($result){
            $result->delete();
        }

        return back()->with('message', "Record deleted");
    }


    public function showStudent($student_id){

        $houses = House::all();
        $classrooms = Classroom::all();
        $guardians = Guardian::where('status', '=', 'active')->get();
        $countries = Country::all();

        $student = Student::with('results', 'classroom', 'guardian', 'house')->where('id', '=', $student_id)->firstOrFail();

        $session_ids = array_unique(Result::where('student_id', '=', $student_id)->pluck('session_id')->toArray());

        $sessions = Session::find($session_ids);


        return view('admin.student')
            ->with('student', $student)
            ->with('sessions', $sessions)
            ->with('houses', $houses)
            ->with('classrooms', $classrooms)
            ->with('guardians', $guardians)
            ->with('countries', $countries);


    }


    public function showStudentResult($student_id, $session_id){

        $student = Student::with('results')->findOrFail($student_id);
        $first_term_results = $student->results()->where('session_id', '=', $session_id)->where('term', '=', 'first')->get();
        $second_term_results = $student->results()->where('session_id', '=', $session_id)->where('term', '=', 'second')->get();
        $third_term_results = $student->results()->where('session_id', '=', $session_id)->where('term', '=', 'third')->get();

        $classroom = $first_term_results->first()->classroom;
        $r_session = $first_term_results->first()->session;


        return view('admin.view_student_result', compact(['first_term_results', 'second_term_results', 'third_term_results', 'classroom', 'student', 'r_session']));

    }

    public function updateStudentResult(Requests\AdminUpdateStudentResult $request, $student_id, $session_id){

        $result = Result::find($request->result_id);

        $result->first_ca = $request->first_ca;
        $result->second_ca = $request->second_ca;
        $result->exam = $request->exam;

        $result->save();

        $score = [];
        $score['first_ca'] = $result->first_ca;
        $score['second_ca'] = $result->second_ca;
        $score['exam'] = $result->exam;
        $score['total'] = $result->total();
        $score['grade'] = $result->grade();
        $score['position'] = $result->position();

        return $score;

    }

    public function updateStudentTermResultsExcel(Requests\AdminUpdateStudentTermResultsExcel $request, $student_id, $session_id){

        $excel_results = Excel::load($request->student_term_results)->get();
        $error_counts = 0;
        foreach($excel_results as $row){

            $subject_id = Subject::where('name', $row->subject)->first()->id;

            $result = Result::where('student_id', $student_id)->where('session_id', $session_id)->where('classroom_id', $request->classroom_id)->where('subject_id', $subject_id)->where('term', $request->term)->first();


                if(isset($result) || !is_null($result) ){

                    if((int)$row->ca1 <= 20 && (int)$row->ca2 <= 20 && (int)$row->exam <= 60){
                        $result->first_ca = (int)$row->ca1;
                        $result->second_ca = (int)$row->ca2;
                        $result->exam = (int)$row->exam;
                        $result->save();
                    }else{
                        $error_counts++;
                    }
            }
        }

        $message = $error_counts > 0 ? 'Student results updated, ' . $error_counts . ' scores not updated' : 'Student results updated successfully';
        return back()->with('message', $message);

    }

    public function licencePage(){
        return view('admin.licence');
    }

    public function addLicence(Request $request){

        if(isValidKey($request->licence_key)){
            addLicenceKey($request->licence_key);
            return back()->with('message', 'New key added successfully');
        }else{
            return back()->with('message', 'Licence key is not valid, try a new key');
        }

    }

    public function promoteStudent(Requests\PromoteStudent $request, $student_id){

    }

    public function promoteAllStudent(Requests\PromoteAllStudent $request, $classroom_id){

    }

    public function repeatStudent(Requests\RepeatStudent $request, $student_id){

    }

    public function repeatAllStudent(Requests\RepeatAllStudent $request, $classroom_id){

    }

    public function showResults(Request $request){


        $results = Result::with('classroom', 'session', 'student', 'teacher', 'subject');


        if(isset($request->session_id) && !is_null($request->session_id) && $request->session_id !== 'All'){

            $results = $results->where('session_id', '=', $request->session_id);
        }

        if(isset($request->term) && !is_null($request->term)){
            $results = $results->where('term', '=', $request->term);
        }

        if(isset($request->classroom_id) && !is_null($request->classroom_id)){
            $results = $results->where('classroom_id', '=', $request->classroom_id);
        }

        if(isset($request->teacher_id) && !is_null($request->teacher_id)){
            $results = $results->where('teacher_id', '=', $request->teacher_id);
        }

        if(isset($request->student_id) && !is_null($request->student_id)){
            $results = $results->where('student_id', '=', $request->student_id);
        }

        if(isset($request->subject_id) && !is_null($request->subject_id)){
            $results = $results->where('subject_id', '=', $request->subject_id);
        }

        return view('admin.scores_sheet')->with('results', $results->paginate(1000));

    }

    public function showProfile(){

        return view('admin.profile');
    }

    public function resetPassword(Request $request){



        $validator = Validator::make($request->all(), [
            'username' => 'required|max:255|exists:users,username',
            'password' => 'required|min:8|confirmed',
        ]);

        if(Auth::user()->isAdmin()){

            if($validator->passes()){
                $user = Auth::user();
                $user->password = bcrypt($request->password);
                $user->save();
                return back()->with('message', 'Password changed successfully');
            }else{
                return back()->withErrors($validator)->with('message', 'something went wrong');
            }

        }else{
            Auth::logout();

            abort(403);
        }

    }


    public function showGuardian($guardian_id){

        $guardian = Guardian::with('students')->findOrFail($guardian_id);

        return view('admin.guardian')->with('guardian', $guardian);


    }

    public function guardianIdFromPhone(Request $request){
        return "here";
    }




}
