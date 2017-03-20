<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Psychomotor extends Model
{
    protected $table = "psychomotors";

    protected $fillable = [ 'term', 'student_id', 'classroom_id', 'session_id', 'teacher_id', 'handwriting', 'drawing_painting', 'games_sports', 'computer_appreciation',
                            'recitation_skills', 'punctuality', 'neatness', 'politeness', 'cooperation',
                            'leadership', 'emotional_stability', 'health', 'attitude_to_work', 'attentiveness'];
    public $timestamps = false;
}
