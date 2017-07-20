<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateResultsTableAddUniqueIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("results", function(Blueprint $table){
           $table->unique(["student_id", "classroom_id", "session_id", "term", "subject_id"], "student_classroom_session_term_subject_unique");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("results", function(Blueprint $table) {
            $table->dropUnique('student_classroom_session_term_subject_unique');
        });
    }
}
