<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    protected $table = 'guardians';
    protected $fillable = ['title','name','email','phone','guardian_id',
        'address','occupation', 'user_id', 'image','sex','status','country_id','state_id','lga_id'
    ];


    public function students(){
        return $this->hasMany('App\Student');
    }

    public function state(){
        return $this->belongsTo('App\State');
    }

    public function lga(){
        return $this->belongsTo('App\Lga');
    }

    public function active_students(){
        return $this->students()->whereIn('status', ['active', 'promoting', 'graduating', 'repeating', 'repeated', 'promoted']);
    }

}
