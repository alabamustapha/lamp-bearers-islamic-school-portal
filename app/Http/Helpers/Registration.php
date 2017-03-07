<?php



function generate_student_admin_number($format = null){

    $session = \App\Session::where('status', '=', 'active')->first();

    if(isset($session) && !is_null($session)){


        $last_admin_number = \App\Student::where('admin_number', 'like', '%' . $format . '%')->count();

        $admin_number =  str_pad(++$last_admin_number, 4, '0', 0);

        return $format . '/' . $admin_number;
    }else{
        return '';
    }
}


function generate_staff_id($format = '2018/2019'){

    $staff_ids = \App\Teacher::all()->pluck('staff_id')->toArray();


    $last_staff_id = (int)str_replace('S', '0',array_last($staff_ids));


    return 'S' . str_pad(++$last_staff_id, 4, '0', 0);

}


function generate_guardian_id(){

    $session = \App\Session::where('status', '=', 'active')->first();

    if(isset($session) && !is_null($session)){

        $last_guardian_id = \App\Guardian::where('guardian_id', 'like', 'G' . $session->name . '%')->count();

        $guardian_id =  str_pad(++$last_guardian_id, 4, '0', 0);

        return 'G' . substr(explode('/', $session->name)[0], 2) . $guardian_id;
    }else{
        return '';
    }

}

function session_on(){
    $session = \App\Session::where('status', '=', 'active')->first();



    if($session){
        return $session;
    }else{
        return false;
    }
}

function term_on(){

    if($session = session_on()){

        if($session->term() == 'first'){
            return 'first';
        }elseif($session->term() == 'second'){
            return 'second';
        }elseif($session->term() == 'third'){
            return 'third';
        }else{
            return false;
        }

    }else{
        return false;
    }

}