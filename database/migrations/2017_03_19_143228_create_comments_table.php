<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function(Blueprint $table){
            $table->increments('id');
            $table->enum('term', ['first', 'second', 'third']);
            $table->text('body')->nullable();
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('classroom_id');
            $table->unsignedInteger('session_id');
            $table->unsignedInteger('teacher_id')->nullable();

            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('classroom_id')->references('id')->on('classrooms');
            $table->foreign('teacher_id')->references('id')->on('teachers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comments');
    }
}
