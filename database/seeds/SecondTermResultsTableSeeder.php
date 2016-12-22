<?php

use Illuminate\Database\Seeder;

class SecondTermResultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $session = \App\Session::where('status', '=', 'active')->first();

        $results = \App\Result::where('session_id', '=', $session->id)->get();

        foreach($results as $result){

          $exist =  \App\Result::where('session_id', '=', $result->session_id)
                ->where('student_id', '=', $result->student_id)
                ->where('subject_id', '=', $result->subject_id)
                ->where('classroom_id', '=', $result->classroom_id)
                ->where('teacher_id', '=', $result->teacher_id)
                ->where('term', '=', 'third')->get();

            if($exist->count() == 0)
                \App\Result::create([
                'session_id' => $result->session_id,
                'student_id' => $result->student_id,
                'subject_id' => $result->subject_id,
                'classroom_id' => $result->classroom_id,
                'teacher_id' => $result->teacher_id,
                'first_ca' => rand(5,20),
                'second_ca' => rand(4,20),
                'exam' => rand(10,57),
                'term' => 'third',
            ]);
        }
    }
}
