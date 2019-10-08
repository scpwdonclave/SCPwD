<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateFormValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guard('center')->user()->id;    
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [

            'doc_no' => ['required','unique:candidates','regex:/^([a-zA-Z]){3}([0-9]){7}|^(\d){12}$/'],
            
            /* TR Basic Details */
            'name' => 'required',
            'email' => 'nullable|email|unique:candidates',
            'contact' => 'required|numeric|unique:candidates',
            /* End TR Basic Details */
            
            'gender' => 'required',
            'dob' => 'required',
            'm_status' => 'required',
            'job' => 'required|numeric',
            'd_type' => 'required|numeric',
            
            'category' => 'required',
            'service' => 'required',
            'education' => 'required',
            'g_name' => 'required',
            'g_type' => 'required',
            'address' => 'required',
            'state_district' => 'required',
            
            'doc_file' => 'required|mimes:jpeg,jpg,png,pdf',
            'd_cert' => 'nullable|mimes:jpeg,jpg,png,pdf',
            
        ];

        return $rules;
    }
}
