<?php


function position($scores_array, $score){

    rsort($scores_array);

    $scores_array = array_unique($scores_array);

    arsort($scores_array);

    if(in_array($score, $scores_array)){
        return array_keys($scores_array, $score)[0] + 1;
    }else{
        return 'N/A';
    }
}

function classroom_percentages($classroom_id, $session_id, $term){

    $percentages = [];

    $students_ids = array_unique(\App\Result::where('classroom_id', '=', $classroom_id)->where('session_id', '=', $session_id)->where('term', '=', $term)->pluck('student_id')->toArray());

    $students = \App\Student::find($students_ids);

    if($term == 'third'){
        foreach($students as $student){
            $percentages[] = $student->third_term_percentage($student->results()->where('session_id', '=', $session_id)->where('term', '=', $term)->get());
        }
    }else{
        foreach($students as $student){
            $percentages[] = $student->term_percentage($student->results()->where('session_id', '=', $session_id)->where('term', '=', $term)->get());
        }
    }


    return $percentages;

}

function remark($score){
    if(isset($score) && !is_null($score)){

        if(grade($score) == 'A') return 'Excellent';
        if(grade($score) == 'B') return 'V.Good';
        if(grade($score) == 'C') return 'Good';
        if(grade($score) == 'D') return 'Fair';
        if(grade($score) == 'E') return 'Poor';
        if(grade($score) == 'F') return 'Fail';

        return 'N/A';

    }else{
        return 'N/A';
    }
}

function grade($average){
    if(isset($average) && !is_null($average)){

        if($average >= 70) return 'A';
        if($average >= 60) return 'B';
        if($average >= 50) return 'C';
        if($average >= 45) return 'D';
        if($average >= 40) return 'E';

        return 'F';

    }else{
        return 'N/A';
    }
}

function head_teacher_remark($average){

        if(isset($average) && !is_null($average)){

            if($average >= 80) return rand(1, 2) == 1 ? 'An excellent result' : 'An outstanding result';
            if($average >= 70) return 'A very good performance, keep it up';
            if($average >= 60) return 'A good result, put in more work next term';
            if($average >= 50) return 'An average result, work harder next term';
            //if($average >= 40) return 'Work harder';
            if($average < 50) return  'Work harder';

            return 'N/A';

        }else{
            return 'N/A';
        }



}

function third_term_remark($average, $session_id, $student){

    $remarks = class_teacher_remark($average);

    $session = \App\Session::where('status', '=', 'active')->first();
    if($session_id == $session->id){

        if($student->status == 'promoting' || $student->status == 'promoted'){

            $remarks .= ' promoted to ' . $student->classroom->name;


        }elseif($student->status == 'repeating' || $student->status == 'repeated'){

            $remarks .= ' repeated to ' . $student->classroom->name;

        }

    }

    return $remarks;


}


function house_master_remark($average){
    return 0;
}
