<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolFeePayment extends Model
{
    protected $table = 'school_fee_payments';

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
