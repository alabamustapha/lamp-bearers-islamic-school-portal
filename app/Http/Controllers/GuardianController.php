<?php

namespace App\Http\Controllers;

use App\Guardian;
use App\Country;
use App\Result;
use App\Role;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class GuardianController extends Controller
{

    public  function index(){
        $guardians = Guardian::with('students')->get();
        return view('guardian.index')->with('guardians', $guardians);
    }


    public function create(){
        $countries = Country::all();
        $guardian_id = generate_guardian_id();
        return view('guardian.create')->with(['countries' => $countries, 'guardian_id' => $guardian_id]);
    }


    public function store(Requests\StoreNewGuardian $request){


        $user = new User;

        $user->username = $request->guardian_id;

        $user->password = bcrypt($request->phone);

        $user->save();

        event(new Registered($user));

        $user->addRole(Role::where('name', '=', 'guardian')->first()->id);



        $guardian = Guardian::create([
            'title'         => $request->title,
            'name'          => $request->surname . ' ' . $request->first_name . ' ' . $request->middle_name,
            'user_id'       => $user->id,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'guardian_id'   => $request->guardian_id,
            'address'       => $request->address,
            'occupation'    => $request->occupation,
            'sex'           => $request->sex,
            'country_id'    => $request->country_id,
            'state_id'      => $request->state_id,
            'lga_id'        => $request->lga_id
        ]);


        if ($request->hasFile('image')) {

            if ($request->file('image')->isValid()) {
                $path = $request->image->store('public/images/guardian/profile');

                $guardian->image = str_replace('public/', null, $path); // remove the /public temporary fix
                $guardian->save();

                return back()->with('Message', 'Guardian record created successfully');
            }
        }

        return back()->with('Message', 'Guardian record created successfully, upload image again');
    }

    public function dashboard(){
        $guardian = Guardian::with('students')->findOrFail(Auth::user()->guardian->id);
        return view('guardian.dashboard')->with('guardian', $guardian );
    }

    public function showWards(){
        $guardian = Guardian::with('students')->findOrFail(Auth::user()->guardian->id);
        return view('guardian.wards')->with('guardian', $guardian);
    }

    public function showWard($student_id){
        $guardian = Guardian::with('students')->findOrFail(Auth::user()->guardian->id);

        $student = Student::with('results', 'classroom')->findOrFail($student_id);

        return view('guardian.ward')->with('student', $student)->with('guardian', $guardian);
    }

    public function showResult(Request $request, $student_id){

        $student = Student::with('guardian', 'classroom')->where('id', '=', $student_id)->first();



        if(isset($request->session_id) && isset($request->term) && !is_null($request->session_id) && !is_null($request->term)){
            $results = Result::where('classroom_id', '=', $request->classroom_id)
                ->where('student_id', '=', $student_id)
                ->where('session_id', '=', $request->session_id)->where('term', '=', $request->term)->get();

            if($request->term == 'first') {

                return view('student.first_term_result')->with('results', $results)->with('student',  $student);
            }
        }else{

        }


    }


}
