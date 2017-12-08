<?php


function expected_term_payment($session, $term){

    $classrooms = \App\Classroom::with('students')->get();

    $total = 0;

    foreach($classrooms as $classroom){
        $students_count = $classroom->students->whereIn('status', ['active', 'promoting', 'promoted', 'repeating', 'repeated', 'graduating'])->count();

        if($students_count > 0){

            if($term == 'first'){
                $total += $classroom->first_term_charges * $students_count;
            }elseif($term == 'second'){
                $total += $classroom->second_term_charges * $students_count;
            }elseif($term == 'third'){
                $total += $classroom->third_term_charges * $students_count;
            }else{
                return  NULL;
            }

        }

    }

    return $total;
}


function term_payment($session_id, $term){

    $school_fee_payments = \App\SchoolFeePayment::where('session_id', '=', $session_id)->where('term', '=', $term)->sum('amount');

    return $school_fee_payments;

}

function term_debt($session_id, $term){

    $school_fee_payments = \App\SchoolFeePayment::where('session_id', '=', $session_id)->where('term', '=', $term)->whereStatus('debt')->sum('amount');

    return $school_fee_payments;

}


function term_part_payment($session_id, $term){

    $school_fee_payments = \App\SchoolFeePayment::where('session_id', '=', $session_id)->where('term', '=', $term)->whereStatus('part')->sum('amount');

    return $school_fee_payments;

}

function term_full_payment($session_id, $term){

    $school_fee_payments = \App\SchoolFeePayment::where('session_id', '=', $session_id)->where('term', '=', $term)->whereStatus('payed')->sum('amount');

    return $school_fee_payments;

}

function has_term_payment($student, $session_id, $term){

    $payment = \App\SchoolFeePayment::where('student_id', '=', $student->id)
                                ->where('session_id', '=', $session_id)
                                ->where('term', '=', $term)
                                ->where('status', '=', 'payed')->first();

    if($payment){
        return true;
    }else{
        return false;
    }

}

