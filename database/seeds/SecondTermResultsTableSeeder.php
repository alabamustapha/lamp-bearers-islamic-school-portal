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
        $students = \App\Student::where('status', '=', 'active')->get();

        $session = \App\Session::where('status', '=', 'active')->first();

        //  dd(\App\Result::where('session_id', '=', $session->id)->count());

        foreach($students as $student){

            $student_classroom = $student->classroom;

            foreach($student_classroom->subjects as $subject){

                $result = \App\Result::where('session_id', '=', $session->id)
                    ->where('term','=','second')
                    ->where('subject_id', '=', $subject->id)
                    ->where('student_id', '=', $student->id)
                    ->where('classroom_id', '=', $student->classroom->id)->first();

                if(!isset($result) && is_null($result)){
                    \App\Result::create([
                        'session_id' => $session->id,
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'classroom_id' => $student->classroom->id,
                        'teacher_id' => $subject->pivot->teacher_id,
                        'first_ca' => rand(5,20),
                        'second_ca' => rand(4,20),
                        'exam' => rand(10,60),
                        'term' => 'second'
                    ]);
                }

            }


        }
    }
//    public function run()
//    {
//
//        $session = \App\Session::where('status', '=', 'active')->first();
//
//        $results = \App\Result::where('session_id', '=', $session->id)->get();
//
//        foreach($results as $result){
//
//          $exist =  \App\Result::where('session_id', '=', $result->session_id)
//                ->where('student_id', '=', $result->student_id)
//                ->where('subject_id', '=', $result->subject_id)
//                ->where('classroom_id', '=', $result->classroom_id)
//                ->where('term', '=', 'second')->get();
//
//            if($exist->count() == 0)
//                \App\Result::create([
//                'session_id' => $result->session_id,
//                'student_id' => $result->student_id,
//                'subject_id' => $result->subject_id,
//                'classroom_id' => $result->classroom_id,
//                'teacher_id' => $result->teacher_id,
//                'first_ca' => rand(5,20),
//                'second_ca' => rand(4,20),
//                'exam' => rand(10,57),
//                'term' => 'second',
//            ]);
//        }
//    }
}
