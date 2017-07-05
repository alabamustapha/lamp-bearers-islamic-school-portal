<?php

namespace App\Http\Controllers;

use App\Guardian;
use App\Country;
use App\Result;
use App\Role;
use App\SchoolFeePayment;
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

        $total_outstanding_payments = 0;

        $session = session_on();
        $term = term_on();
        if($session  && $term ){
            foreach($guardian->active_students as $student){

                if(!has_term_payment($student, $session->id, $term)) {

                    if ($term == 'first') {
                        $total_outstanding_payments += $student->classroom->first_term_charges;
                    } elseif ($term == 'second') {
                        $total_outstanding_payments += $student->classroom->second_term_charges;
                    } elseif ($term == 'third') {
                        $total_outstanding_payments += $student->classroom->third_term_charges;
                    }
                }
            }
        }

        $total_debts = SchoolFeePayment::where('guardian_id', $guardian->id)->where('status', 'debt')->sum('balance');

        return view('guardian.dashboard')->with('guardian', $guardian )->with('total_outstanding_payments', $total_outstanding_payments)->with('total_debts', $total_debts);
    }

    public function showWards(){
        $guardian = Guardian::with('students')->findOrFail(Auth::user()->guardian->id);


        $total_outstanding_payments = 0;

        $session = session_on();
        $term = term_on();
        if($session  && $term ){
            foreach($guardian->active_students as $student){

                if(!has_term_payment($student, $session->id, $term)) {

                    if ($term == 'first') {
                        $total_outstanding_payments += $student->classroom->first_term_charges;
                    } elseif ($term == 'second') {
                        $total_outstanding_payments += $student->classroom->second_term_charges;
                    } elseif ($term == 'third') {
                        $total_outstanding_payments += $student->classroom->third_term_charges;
                    }
                }
            }
        }

        $total_debts = SchoolFeePayment::where('guardian_id', $guardian->id)->where('status', 'debt')->sum('balance');


        return view('guardian.wards')->with('guardian', $guardian)->with('total_outstanding_payments', $total_outstanding_payments)->with('total_debts', $total_debts);
    }

    public function showWard($student_id){
        $guardian = Guardian::with('students')->findOrFail(Auth::user()->guardian->id);

        $student = Student::with('results', 'classroom')->findOrFail($student_id);

        $academic_history = student_academic_history($student_id, null, null);

        //dd($academic_history);

        return view('guardian.ward')->with('student', $student)->with('guardian', $guardian)->with('academic_history', $academic_history);
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

    public function payments(){
        $guardian = Guardian::with('students')->findOrFail(Auth::user()->guardian->id);

        $current_term_payments = [];
        $part_payments = [];
        $debts = [];
        $email = filter_var($guardian->email, FILTER_VALIDATE_EMAIL)  ? $guardian->email : "redehubng@gmail.com" ;


        $session = session_on();
        $term = term_on();

        if($session  && $term ){
            foreach($guardian->active_students as $student){
                if(!has_term_payment($student, $session->id, $term))

                if($term == 'first'){
                    $amount =  $student->classroom->first_term_charges;
                    $array = ['custom_fields' =>[
                            ['display_name' => "Term", "variable_name"         => "term", "value" => "first"],
                            ['display_name' => "User ID", "variable_name"      => "user_id", "value" => Auth::user()->id],
                            ['display_name' => "Student ID", "variable_name"   => "student_id", "value" => $student->id],
                            ['display_name' => "Guardian ID", "variable_name"  => "guardian_id", "value" => $guardian->id],
                            ['display_name' => "Session ID", "variable_name"   => "session_id", "value" => $session->id],
                            ['display_name' => "Classroom ID", "variable_name" => "classroom_id", "value" => $student->classroom->id],
                            ['display_name' => "Amount", "variable_name"       => "amount", "value" => $amount],
                        ]
                    ];

                    $metadata = json_encode($array);

                    $current_term_payments[] = ['student' => $student, 'amount' => $amount, 'email' => $email, 'metadata' => $metadata, 'term' => 'first'];

                    }elseif($term == 'second'){

                    $amount =  $student->classroom->second_term_charges;
                    $array = ['custom_fields' =>[
                        ['display_name' => "Term", "variable_name"         => "term", "value" => "second"],
                        ['display_name' => "User ID", "variable_name"      => "user_id", "value" => Auth::user()->id],
                        ['display_name' => "Student ID", "variable_name"   => "student_id", "value" => $student->id],
                        ['display_name' => "Guardian ID", "variable_name"  => "guardian_id", "value" => $guardian->id],
                        ['display_name' => "Session ID", "variable_name"   => "session_id", "value" => $session->id],
                        ['display_name' => "Classroom ID", "variable_name" => "classroom_id", "value" => $student->classroom->id],
                        ['display_name' => "Amount", "variable_name"       => "amount", "value" => $amount],
                    ]
                    ];

                    $metadata = json_encode($array);

                    $current_term_payments[] = ['student' => $student, 'amount' => $amount, 'email' => $email, 'metadata' => $metadata, 'term' => 'second'];

                    }elseif($term == 'third'){

                    $amount =  $student->classroom->third_term_charges;
                    $array = ['custom_fields' =>[
                        ['display_name' => "Term", "variable_name"         => "term", "value" => "third"],
                        ['display_name' => "User ID", "variable_name"      => "user_id", "value" => Auth::user()->id],
                        ['display_name' => "Student ID", "variable_name"   => "student_id", "value" => $student->id],
                        ['display_name' => "Guardian ID", "variable_name"  => "guardian_id", "value" => $guardian->id],
                        ['display_name' => "Session ID", "variable_name"   => "session_id", "value" => $session->id],
                        ['display_name' => "Classroom ID", "variable_name" => "classroom_id", "value" => $student->classroom->id],
                        ['display_name' => "Amount", "variable_name"       => "amount", "value" => $amount],
                    ]
                    ];

                    $metadata = json_encode($array);

                    $current_term_payments[] = ['student' => $student, 'amount' => $amount, 'email' => $email, 'metadata' => $metadata, 'term' => 'third'];
                    }

            }
        }


        //dd($current_term_payments);

        return view('guardian.payments', compact(['guardian', 'current_term_payments']));
    }



}
