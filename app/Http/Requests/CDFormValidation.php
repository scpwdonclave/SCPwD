<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CDFormValidation extends FormRequest
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

            'doc_no' => [
                'required',
                'regex:/^([A-Z]){3}([0-9]){7}|^(\d){12}$/',
                'unique:candidates,doc_no',
                'unique:trainer_statuses,doc_no',
                'unique:agencies,aadhaar',
                'unique:assessors,aadhaar',
            ],
            
            /* TR Basic Details */
            'name' => 'required',
            'email' => [
                'nullable',
                'email',
                'unique:admins,email',
                'unique:trainers,email',
                'unique:partners,email',
                'unique:centers,email',
                'unique:candidates,email',
                'unique:trainer_statuses,email',
                'unique:agencies,email',
                'unique:assessors,email'
            ],

            'contact' => [
                'required',
                'numeric',
                'min:10',
                'unique:trainers,mobile',
                'unique:partners,spoc_mobile',
                'unique:centers,mobile',
                'unique:candidates,contact',
                'unique:trainer_statuses,mobile',
                'unique:agencies,mobile',
                'unique:assessors,mobile',
            ],

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
            'd_cert' => 'required|mimes:jpeg,jpg,png,pdf',
            
        ];

        return $rules;
    }
}
