<?php

namespace App\Http\Requests;

use App\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateStudentsRecord extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
//        if(!Auth::user()->isAdmin()){
//            return false;
//        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $student = Student::find($this->route('student_id'));
        return [
            'email'         => 'email|unique:students,email,'.$student->id,
            'phone'         => 'unique:students,phone,'.$student->id,
            'address'       => 'min:10',
            'comment'       => 'min:4',
            'house_id'      => 'integer|exists:houses,id',
            'classroom_id'      => 'integer|exists:classrooms,id',
            'status'        => 'in:active,promoting,promoted,repeating,repeated,left,dismissed,graduated,graduating,deactivated',
            'guardian_id'   => 'nullable|integer|exists:guardians,id',
            'image'         => 'mimes:jpeg,jpg,png|max:120|unique:students,image,'.$student->id,
        ];
    }
}
