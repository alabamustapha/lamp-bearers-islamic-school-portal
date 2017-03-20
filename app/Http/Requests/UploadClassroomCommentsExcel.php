<?php

namespace App\Http\Requests;

use App\Classroom;
use App\Session;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadClassroomCommentsExcel extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {

        $classroom = Classroom::find($this->route('classroom_id'));

        $session = Session::where('status', 'active')->first();

        if($classroom->teacher->user->id ==  Auth::user()->id && isset($session) && !is_null($session)){
            if($session->first_term == 'active' && $request->term == 'first' || $session->second_term == 'active' && $request->term == 'second' || $session->third_term == 'active' && $request->term == 'third'){
                return true;
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
            'type' => 'required|in:comments,psychomotors,attendance',
            'term' => 'required|in:first,second,third',
            'classroom_id' => 'required|exists:classrooms,id',
            'teacher_id' => 'required|exists:teachers,id',
            'session_id' => 'required|exists:sessions,id',
            'comments_physchomotor' => 'required|mimes:xls,xlsx,csv'
        ];
    }
}
