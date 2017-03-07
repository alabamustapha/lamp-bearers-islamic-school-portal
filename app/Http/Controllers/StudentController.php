<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Country;
use App\Guardian;
use App\House;
use App\Result;
use App\Role;
use App\Session;
use App\Student;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(){
        $students = Student::whereIn('status', ['active', 'graduating', 'promoting', 'promoted', 'repeating', 'repeated'])->get();
        return view('student.index')->with('students', $students);

    }

    public function dashboard(){
        $student = Student::with('results', 'guardian', 'classroom', 'house')->where('admin_number', '=', Auth::user()->username)->first();

        return view('student.dashboard', compact('student'));
    }

    public function create(){

        $session = Session::where('status', '=', 'active')->first();

        if(!isset($session) || is_null($session)){
            return back()->with('message', 'you cant create student record when no session is active');
        }
        $houses = House::all();
        $classrooms = Classroom::all();
        $guardians = Guardian::where('status', '=', 'active')->get();
        $countries = Country::all();
        $admin_number = generate_student_admin_number('LBS/' . substr(explode('/', $session->name)[0], 2));

        return view('student.create')
            ->with('houses', $houses)
            ->with('classrooms', $classrooms)
            ->with('guardians', $guardians)->with('countries', $countries)->with('admin_number', $admin_number);
    }

    public function store(Requests\StoreNewStudent $request){


      //  dd($request->all());

        $user = new User;

        $user->username = $request->admin_number;

        $user->password = bcrypt($request->surname);

        $user->save();

        event(new Registered($user));

        $user->addRole(Role::where('name', '=', 'student')->first()->id);


        $student = Student::create([
            'name'          => $request->surname . ' ' . $request->first_name . ' ' . $request->middle_name,
            'user_id'       => $user->id,
            'email'         => $request->email == "" ? null : $request->email,
            'phone'         => $request->phone == "" ? null : $request->phone,
            'dob'           => Carbon::createFromFormat('m/d/Y', $request->dob),
            'date_admitted' => Carbon::createFromFormat('m/d/Y', $request->date_admitted),
            'admin_number'  => $request->admin_number,
            'address'       => $request->address,
            'religion'      => $request->religion,
            'comment'       => $request->comment,
            'sex'           => $request->sex,
            'country_id'    => $request->country_id,
            'state_id'      => $request->state_id,
            'lga_id'        => $request->lga_id,
            'house_id'      => $request->house_id,
            'classroom_id'  => $request->classroom_id,
            'starting_classroom_id'        => $request->classroom_id,
            'guardian_id'        => $request->guardian_id == '' ? null : $request->guardian_id
        ]);



        if ($request->hasFile('image')) {

            if ($request->file('image')->isValid()) {
                $path = $request->image->store('public/images/student/profile');
                $student->image = str_replace('public/', null, $path);
                $student->save();

                return back()->with('Message', 'Student record created successfully');
            }
        }

        return back()->with('Message', 'Student record created successfully, upload image again');


    }


    public function showResults(Request $request, $student_id){

        $student = Student::with('guardian', 'classroom')->where('id', '=', $request->student_id)->first();



        if(isset($request->session_id) && isset($request->term) && !is_null($request->session_id) && !is_null($request->term)){

            $results = Result::where('student_id', '=', $request->student_id)
                ->where('session_id', '=', $request->session_id)->where('term', '=', $request->term)->get();


            if($request->term == 'first') {
                return view('student.first_term_result')->with('results', $results)->with('student',  $student)->with('session_id', $request->session_id);
            }elseif($request->term == 'second'){
                return view('student.second_term_result')->with('results', $results)->with('student',  $student)->with('session_id', $request->session_id);
            }elseif($request->term == 'third'){
                return view('student.third_term_result')->with('results', $results)->with('student',  $student)->with('session_id', $request->session_id);
            }

        }else{

            return '';

        }


    }


    public function update(Requests\UpdateStudentsRecord $request, $id){


        if(!Auth::user()->isAdmin()){
            return back()->with('message', 'you dont have the permission to update this record');
        }

        $student = Student::findOrFail($id);

        $student->classroom_id = $request->classroom_id;
        $student->house_id =  $request->house_id;
        $student->address = $request->address;
        $student->guardian_id = $request->guardian_id == "" ? null : $request->guardian_id;
        $student->email = $request->email == "" ? null : $request->email;
        $student->phone = $request->phone == "" ? null : $request->phone;
        $student->comment = $request->comment;
        $student->name = $request->surname . ' ' . $request->first_name . ' ' . $request->middle_name;

        $student->dob = Carbon::createFromFormat('m/d/Y', $request->dob);


        if ($request->hasFile('image')) {

            if ($request->file('image')->isValid()) {

                if(has_image($student)){

                    if(delete_profile_image($student)){
                        $path = $request->image->store('public/images/student/profile');
                        $student->image = str_replace('public/', null, $path);
                    }else{
                        return back()->with('message', 'Image could not be updated');

                    }

                }else{

                $path = $request->image->store('public/images/student/profile');
                    $student->image = str_replace('public/', null, $path);
                }


            }
        }



        $student->save();

        return back()->with('message', 'Student record updated');
    }


    public function showAcademicHistory(){
        $student = Student::with('results', 'guardian', 'classroom', 'house')->where('admin_number', '=', Auth::user()->username)->first();
        $session_ids = array_unique($student->results->pluck('session_id')->toArray());

        $sessions = Session::find($session_ids);

        return view('student.academic_history', compact('student', 'sessions'));
    }


}
