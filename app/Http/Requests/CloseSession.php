<?php

namespace App\Http\Requests;

use App\Session;
use App\Student;
use Illuminate\Foundation\Http\FormRequest;

class CloseSession extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        $session = Session::find($this->route('session_id'));

//        if(Student::where('status', '=', 'active')->get()->count()){
//            return false;
//        }

        if(isset($session) && !is_null($session) &&
            $session->first_term === 'closed' &&
            $session->second_term === 'closed' &&
            $session->third_term === 'closed'){

            return true;
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
            'session_id' => 'exists:sessions,id',
        ];
    }
}
