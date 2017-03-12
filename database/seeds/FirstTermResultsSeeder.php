<?php

use Illuminate\Database\Seeder;

class FirstTermResultsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = \App\Student::where('status', '=', 'active')->get();

        $session = \App\Session::where('status', '=', 'active')->first();

      //  dd(\App\Result::where('session_id', '=', $session->id)->count());

        foreach($students as $student){

            $student_classroom = $student->classroom;

            foreach($student_classroom->subjects as $subject){

                $result = \App\Result::where('session_id', '=', $session->id)
                    ->where('term','=','first')
                    ->where('subject_id', '=', $subject->id)
                    ->where('student_id', '=', $student->id)
                    ->where('classroom_id', '=', $student->classroom->id)
                    ->where('teacher_id', '=',   $subject->pivot->teacher_id)->first();

                    if(!isset($result) && is_null($result)){
                        \App\Result::create([
                            'session_id' => $session->id,
                            'student_id' => $student->id,
                            'subject_id' => $subject->id,
                            'classroom_id' => $student->classroom->id,
                            'teacher_id' => $subject->pivot->teacher_id,
                            'first_ca' => 0,
                            'second_ca' => 0,
                            'exam' => 0,
                            'term' => 'first'
                        ]);
                    }

            }


        }
    }
}
