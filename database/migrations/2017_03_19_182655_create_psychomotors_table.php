<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePsychomotorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psychomotors', function(Blueprint $table){
            $table->increments('id');
            $table->enum('term', ['first', 'second', 'third']);
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('classroom_id');
            $table->unsignedInteger('session_id');
            $table->unsignedInteger('teacher_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('classroom_id')->references('id')->on('classrooms');
            $table->foreign('teacher_id')->references('id')->on('teachers');

            $table->enum('handwriting', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->enum('drawing_painting', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->enum('games_sports', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->enum('computer_appreciation', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->enum('recitation_skills', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->enum('punctuality', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->enum('neatness', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->enum('politeness', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->enum('cooperation', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->enum('leadership', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->enum('emotional_stability', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->enum('health', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->enum('attitude_to_work', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->enum('attentiveness', ['A', 'B', 'C', 'D', 'E'])->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('psychomotors');
    }
}
