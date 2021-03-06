<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\ClassroomSubject;
use App\Level;
use App\Student;
use App\Subject;
use App\Teacher;
use Illuminate\Http\Request;

use App\Http\Requests;

class ClassroomController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        $classrooms = Classroom::all();
        $levels = Level::all();
        return view('classroom.index')->with('teachers', $teachers)->with('classrooms', $classrooms)->with('levels', $levels);
    }

    public function store(Requests\StoreNewClassroom $request)
    {

        Classroom::create([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
            'level_id' => $request->level_id,
            'first_term_charges' => $request->first_term_charges,
            'second_term_charges' => $request->second_term_charges,
            'third_term_charges' => $request->third_term_charges
        ]);

        return back()->with('Classroom created successfully');

    }

    public function show($classroom_id)
    {
        $classroom = Classroom::with(['promoting_and_repeating_students', 'students'])->where('id', '=', $classroom_id)->firstOrFail();
        $teachers = Teacher::all();
        $levels = Level::all();
        $classrooms = Classroom::all();
        $classroom_subjects = ClassroomSubject::where('classroom_id', '=', $classroom_id)->with('subject', 'teacher', 'classroom')->get();
        $subjects = Subject::all();


        return view('classroom.show')
            ->with('classroom', $classroom)
            ->with('teachers', $teachers)
            ->with('levels', $levels)
            ->with('classroom_subjects', $classroom_subjects)
            ->with('classrooms', $classrooms)
            ->with('subjects', $subjects);

    }


    public function edit($classroom_id)
    {
        $classroom = Classroom::where('id', '=', $classroom_id)->firstOrFail();
        $teachers = Teacher::all();
        $levels = Level::all();

        return view('classroom.edit')
            ->with('classroom', $classroom)
            ->with('teachers', $teachers)
            ->with('levels', $levels);
    }

    public function update(Request $request, $id)
    {
        $classroom = Classroom::find($id);

        $classroom->name = $request->name;
        $classroom->teacher_id = $request->teacher_id;
        $classroom->first_term_charges = $request->first_term_charges;
        $classroom->second_term_charges = $request->second_term_charges;
        $classroom->third_term_charges = $request->third_term_charges;

        $classroom->save();

        return back()->with('message', 'Classroom updated');
    }

    public function declinePromotion(Request $request, $classroom_id){
        $students = Student::where('previous_classroom_id', $request->classroom_id)
                ->where('status', 'promoting')
                ->update([
                    'classroom_id' => $request->classroom_id,
                    'status' => 'active',
                    'previous_classroom_id' => null
                ]);

        $students = Student::where('previous_classroom_id', $request->classroom_id)->where('classroom_id', $request->classroom_id)
            ->where('status', 'repeating')
            ->update([
                'classroom_id' => $request->classroom_id,
                'status' => 'active',
                'previous_classroom_id' => null
            ]);

        //dd($students);
        return back()->with('message', "Promotion / Repeating declined successfully");
    }


}