<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewStudent extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

             return [
                 'first_name'    => 'required|min:3',
                 'middle_name'   => 'nullable',
                 'surname'       => 'required|min:3',
                 'email'         => 'email|unique:students,email',
                 'phone'         => 'unique:students,phone',
                 'dob'           => 'required|date',
                 'date_admitted' => 'required|date',
                 'admin_number'  => 'required|unique:students,admin_number',
                 'address'       => 'nullable|min:10',
                 'comment'       => 'nullable|string',
                 'sex'           => 'required|in:Male,Female',
                 'religion'      => 'required|in:Christianity,Islam,Other',
                 'user_id'       => 'integer|exists:users,id',
                 'house_id'      => 'integer|exists:houses,id',
                 'guardian_id'   => 'nullable|integer|exists:guardians,id',
                 'country_id'    => 'required|integer|exists:countries,id',
                 'state_id'      => 'required|integer|exists:states,id',
                 'lga_id'        => 'required|integer|exists:lgas,id',
                 'image'         => 'mimes:jpeg,jpg,png|max:120|unique:students,image',
             ];

    }
}
