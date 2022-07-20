<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorAccountRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'=>'required|unique:users,email',
            'name'=>'required|string',
            'password'=>'required|string',
            'picture'=>'required|image|mimes:jpeg,jpg,png|max:2048',
            'specialization'=>'required|string',
            'experience_years'=>'required|integer',
            'experience'=>'required|string',

        ];
    }
}
