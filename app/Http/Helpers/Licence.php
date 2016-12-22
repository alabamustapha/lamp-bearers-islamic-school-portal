<?php


function active_licence_key(){

    if(licence_file_exist()){

        return get_licence_key();

    }else{

        create_licence_file();

        return 'Licence file was deleted, created new one. no active licence key';
    }

}

function has_valid_licence_key(){

    $licences = \App\Licence::all()->pluck('licence');

    foreach($licences as $licence){
        if(\Illuminate\Support\Facades\Hash::check(active_licence_key(), $licence)){
            return true;
        }
    }

    return false;

}

function get_licence_key(){

    $licences = fopen(storage_path('app/licence.txt'), 'r') or die('cant open');

    $licences_list = [];

    while(!feof($licences)){

        $licences_list[] = trim(fgets($licences));
    }

    fclose($licences);

    if(count($licences_list) == 1){

        return $licences_list[0];

    }elseif(count($licences_list > 1)){
        return $licences_list[0];
    }else{
        return $licences_list[0];
    }
}

function licence_file_exist(){

    return Storage::disk('local')->exists('licence.txt');

}

function create_licence_file(){
    if(!licence_file_exist()){
        \Illuminate\Support\Facades\Storage::disk('local')->put('licence.txt', '');
    }
}

function isValidKey($key){

    $licences = \App\Licence::all()->pluck('licence');

    foreach($licences as $licence){
        if(\Illuminate\Support\Facades\Hash::check($key, $licence)){
            return true;
        }
    }

    return false;

}

function addLicenceKey($key){
    \Illuminate\Support\Facades\Storage::disk('local')->put('licence.txt', trim($key));
}

function removeLicenceKey($key){
    $licences = \App\Licence::all();

    foreach($licences as $licence){
        if(\Illuminate\Support\Facades\Hash::check($key, $licence->licence)){
            $licence->delete();

            return true;
        }
    }

    return false;

}