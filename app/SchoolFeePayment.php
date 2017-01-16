<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolFeePayment extends Model
{
    protected $table = 'school_fee_payments';

    protected $fillable = ['term','user_id','student_id','guardian_id','session_id','classroom_id','amount','balance','status','reference','transaction_date'];

    public function session(){
        return $this->belongsTo('session');
    }

    public function student(){
        return $this->belongsTo('student');
    }

    public function guardian(){
        return $this->belongsTo('guardian');
    }

    public function user(){
        return $this->belongsTo('user');
    }


}
