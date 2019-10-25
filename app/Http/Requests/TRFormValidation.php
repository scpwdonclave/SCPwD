<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TRFormValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guard('partner')->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [

            'doc_no' => ['required','unique:trainers','regex:/^([a-zA-Z]){3}([0-9]){7}|^(\d){12}$/'],
            
            /* TR Basic Details */
            'name' => 'required',
            'email' => 'required|email|unique:trainers,email|unique:trainer_statuses,email|unique:partners,email|unique:centers,email',
            'mobile' => 'required|numeric|unique:trainers,mobile|unique:trainer_statuses,mobile|unique:partners,spoc_mobile|unique:centers,mobile',
            /* End TR Basic Details */

            'qualification' => 'required|numeric',
            'sector' => 'required|numeric',
            'ssc_doc_no' => 'nullable',
            'ssc_start' => 'nullable',
            'ssc_end' => 'nullable',
            'scpwd_doc_no' => 'nullable',
            'scpwd_start' => 'nullable',
            'scpwd_end' => 'nullable',
            'jobrole' => 'required|numeric',
            
            'ssc_doc' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'scpwd_doc' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'other_doc' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'resume' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'doc_file' => 'required|mimes:jpeg,jpg,png,pdf',
            'qualification_doc' => 'required|mimes:jpeg,jpg,png,pdf',
            
        ];
        return $rules;
    }
}
