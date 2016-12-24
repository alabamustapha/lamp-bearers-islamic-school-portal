<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $dates = ['last_login', 'created_at', 'updated_at', 'last_logout'];

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function hasRole($roleId){
        foreach ($this->roles as $role) {
            if($role->id == $roleId)
                return true;
        }

        return false;
    }

    public function addRole($roleId){
        return $this->roles()->attach($roleId);
    }

    public function removeRole($roleId){
        return $this->roles()->detach($roleId);
    }

    public function isAdmin(){
        return $this->hasRole(Role::where('name', '=', 'admin')->first()->id);
    }

    public function isTeacher(){
        return $this->hasRole(Role::where('name', '=', 'teacher')->first()->id);
    }

    public function isStudent(){
        return $this->hasRole(Role::where('name', '=', 'student')->first()->id);
    }

    public function isGuardian(){
        return $this->hasRole(Role::where('name', '=', 'guardian')->first()->id);
    }

    public function teacher(){
        return $this->hasOne('App\Teacher');
    }

    public function guardian(){
        return $this->hasOne('App\Guardian');
    }

    public function student(){
        return $this->hasOne('App\Student');
    }

    public function profile_image(){

        $link = null;

        if($this->isAdmin()){
            $link = 'images/logo.png';
        }elseif($this->isTeacher()){
            if(has_image($this->teacher)){
                $link =  $this->teacher->image;
            }else{
                $link =  'images/' . strtolower($this->teacher->sex) . '.png';
            }
        }elseif($this->isStudent()){
            if(has_image($this->student)){
                $link =   $this->student->image;
            }else{
                $link =  'images/' . strtolower($this->student->sex) . '.png';
            }
        }elseif($this->isGuardian()){
            if(has_image($this->guardian)){
                $link =  $this->guardian->image;
            }else{
                $link =  'images/' . strtolower($this->guardian->sex) . '.png';
            }
        }else{
            $link = "images/logo.png";
        }


        return $link;

    }
}
