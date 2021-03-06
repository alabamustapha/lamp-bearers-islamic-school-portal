<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $tables = 'classrooms';

    protected $fillable = ['name', 'teacher_id', 'first_term_charges', 'second_term_charges', 'third_term_charges', 'level_id'];

    public function male_students(){
        return $this->students()->where('sex', '=', 'Male')->get();
    }

    public function female_students(){
        return $this->students()->where('sex', '=', 'Female')->get();
    }

    public function active_male_students(){
        return $this->active_students()->where('sex', '=', 'Male');
    }

    public function active_female_students(){
        return $this->active_students()->where('sex', '=', 'Female');
    }

    public function total_students(){
        return $this->students()->count();
    }

    public function active_students(){
        return $this->students()->where('status', '=', 'active')->get();
    }

    public function promoting_and_repeating_students(){
        return $this->hasMany('App\Student', 'previous_classroom_id');
    }

    public function repeated_students(){
        return $this->promoting_and_repeating_students()->where('status', '=', 'repeated')->get();
    }

    public function repeating_students(){
        return $this->promoting_and_repeating_students()->where('status', '=', 'repeating')->get();
    }

    public function promoted_students(){
        return $this->promoting_and_repeating_students()->where('status', '=', 'promoted')->get();
    }

    public function promoting_students(){
        return $this->promoting_and_repeating_students()->where('status', '=', 'promoting')->get();
    }

    public function students(){
        return $this->hasMany('App\Student', 'classroom_id');
    }
    public function teacher(){
        return $this->belongsTo('App\Teacher');
    }

    public function level(){
        return $this->belongsTo('App\Level');
    }

    public function subjects(){
        return $this->belongsToMany('App\Subject', 'classroom_subjects', 'classroom_id', 'subject_id')->withPivot('teacher_id')->withTimestamps();
    }

    public function results(){
        return $this->hasMany('App\Result', 'id', 'classroom_id');
    }

}
