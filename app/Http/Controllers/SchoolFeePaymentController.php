<?php

namespace App\Http\Controllers;

use App\SchoolFeePayment;
use App\Session;
use App\Student;
use Illuminate\Http\Request;

class SchoolFeePaymentController extends Controller
{

    public function showUpcomingSchoolFee(){


        $session = Session::where('status', '=', 'active')->first();

        if($session){

            $student_has_pay_ids = SchoolFeePayment::where('session_id', '=', $session->id)->where('term', '=', $session->term())->pluck('student_id')->toArray();

            $students = Student::with('school_fee_payment')->whereNotIn('id', $student_has_pay_ids)->whereIn('status', ['active', 'promoting', 'promoted', 'repeating', 'repeated', 'graduating'])->get();

            if($session->term() == 'first'){
                $total_amount = 0;
                $term = 'first';
                foreach($students as $student){
                    $total_amount += $student->classroom->first_term_charges;
                }
            }elseif($session->term() == 'second'){
                $total_amount = 0;
                $term = 'second';
                foreach($students as $student){
                    $total_amount += $student->classroom->second_term_charges;
                }
            }elseif($session->term() == 'third'){
                $total_amount = 0;
                $term = 'third';
                foreach($students as $student){
                    $total_amount += $student->classroom->third_term_charges;
                }
            }else{
                $term = 'N/A';
                $total_amount = 0;
            }
        }else{

            $students = new Student();
        }


        return view('admin.upcoming_fee', compact(['students', 'total_amount', 'session', 'term']));

    }

}
