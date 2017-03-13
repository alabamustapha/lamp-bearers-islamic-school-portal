<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Session;
use Illuminate\Http\Request;

class AdminUpdateStudentTermResultsExcel extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {

        $session = Session::find($this->route('session_id'));

        if(isset($session) && !is_null($session)){

            if($session->status == 'active'){
                if($request->term == 'first' && $session->first_term == 'active' || $session->first_term == 'closed'){
                    return true;
                }elseif($request->term == 'second' && $session->second_term == 'active' || $session->second_term == 'closed'){
                    return true;
                }elseif($request->term == 'third' && $session->third_term == 'active' || $session->third_term == 'closed'){
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
            'student_term_results' => 'required|mimes:xls,xlsx,csv'
        ];
    }
}
