<?php

namespace App\Http\Requests;

use App\Session;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TeacherSubjectClassroomTermResults extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {

        $session = Session::where('status', 'active')->first();

        $teacher_subjects = Auth::user()->teacher->classroom_subjects->pluck('subject_id')->toArray();

        if(isset($session) && !is_null($session)){

            if(in_array($request->subject_id, $teacher_subjects)){
                if ($request->term == 'first' && $session->first_term == 'active' || $session->first_term == 'closed') {
                    return true;
                } elseif ($request->term == 'second' && $session->second_term == 'active' || $session->second_term == 'closed') {
                    return true;
                } elseif ($request->term == 'third' && $session->third_term == 'active' || $session->third_term == 'closed') {
                    return true;
                }
        }


        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'term' => 'required|in:first,second,third',
            'subject_id' => 'required|integer|exists:subjects,id',
            'classroom_id' => 'required|integer|exists:classrooms,id',
            'teacher_id' => 'required|integer|exists:teachers,id',
            'students_term_results' => 'required|mimes:xls,xlsx,csv'
        ];
    }
}
