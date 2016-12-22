<?php

function has_image($user){

    if(!isset($user) || !isset($user->image) || is_null($user) || is_null($user->image)){
        return false;
    }

    $status = \Illuminate\Support\Facades\Storage::disk('public')->exists($user->image);
    
    return $status;
}

function delete_profile_image($user){

    if(has_image($user)){
       $status = \Illuminate\Support\Facades\Storage::disk('public')->delete($user->image);

        if($status) {
            $user->image = null;
            $user->save();
        }

    }

    return $status;

}