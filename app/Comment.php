<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";
    protected $fillable = ['student_id', 'classroom_id', 'session_id', 'teacher_id', 'term', 'body'];
    public $timestamps = false;

}
