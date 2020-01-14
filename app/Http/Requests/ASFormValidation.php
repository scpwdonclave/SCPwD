<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ASFormValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guard('agency')->user()->id;    
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            
            'name' => 'required',
            'birth' => 'required',
            'gender' => 'required',
            'religion' => 'nullable',
            'category' => 'nullable',
            'd_type' => 'nullable',

            'language' => 'required|array|min:1',
            'language .*' => 'required|distinct',

            
            'd_certificate' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'aadhaar' => [
                'required',
                'regex:/^\d{12}$/',
                'unique:candidates,doc_no',
                'unique:trainer_statuses,doc_no',
                'unique:agencies,aadhaar',
                'unique:assessors,aadhaar',
            ],
            
            'aadhaar_doc' => 'required|mimes:jpeg,jpg,png,pdf',
            
            'pan' => 'nullable',
            'pan_doc' => 'nullable|mimes:jpeg,jpg,png,pdf',

            'email' => [
                'required',
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

            'mobile' => [
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
            
            
            'photo' => 'required|mimes:jpeg,jpg,png,pdf',
            'address' => 'required',
            'post_office' => 'required',
            'state_district' => 'required',
            'sub_district' => 'required',
            'parliament' => 'required',
            'city' => 'required',
            'pin' => 'required',
            
            'education' => 'nullable',
            'edu_details' => 'nullable',
            'edu_doc' => 'nullable|mimes:jpeg,jpg,png,pdf',
            
            'relevant_sector' => 'required|numeric',
            'exp_year' => 'required|numeric',
            'exp_month' => 'required|numeric|max:12',
            
            'exp_dtl' => 'nullable',
            'industry_dtl' => 'nullable',
            
            'exp_doc' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'resume' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'domain_doc' => 'nullable|mimes:jpeg,jpg,png,pdf',
            
            'sector' => 'required|numeric',
            'job_role' => 'required|array|min:1',
            'job_role.*' => 'required|distinct',
            
            
            'scpwd_certi_no' => 'nullable',
            'certi_date' => 'nullable',
            'certi_end_date' => 'nullable',
            'scpwd_doc' => 'nullable|mimes:jpeg,jpg,png,pdf',
            
        ];

        return $rules;
    }
}
