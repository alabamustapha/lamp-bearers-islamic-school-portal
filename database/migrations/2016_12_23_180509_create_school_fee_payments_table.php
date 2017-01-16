<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolFeePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_fee_payments', function(Blueprint $table){
            $table->increments('id');
            $table->enum('term', ['first', 'second', 'third']);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('guardian_id')->nullable();
            $table->unsignedInteger('session_id');
            $table->unsignedInteger('classroom_id');
            $table->double('amount');
            $table->double('balance');
            $table->enum('status', ['payed', 'debt', 'part']);
            $table->string('reference');
            $table->dateTime('transaction_date');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('guardian_id')->references('id')->on('guardians');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('classroom_id')->references('id')->on('classrooms');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_fee_payments', function(Blueprint $table){
            $table->dropForeign(['classroom_id']);
            $table->dropForeign(['session_id']);
            $table->dropForeign(['student_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['guardian_id']);
        });
        Schema::drop('school_fee_payments');
    }
}
