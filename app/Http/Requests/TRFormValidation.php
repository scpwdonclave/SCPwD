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

            'doc_no' => 'required|unique:trainers',
            
            /* TR Basic Details */
            'name' => 'required',
            'email' => 'required|email|unique:trainers',
            'mobile' => 'required|numeric|unique:trainers',
            /* End TR Basic Details */
            
            'sector' => 'required|array|min:1',
            'sector.*' => 'required',
            'ssc_doc_no' => 'required|array|min:1',
            'ssc_doc_no.*' => 'required',
            'ssc_start' => 'required|array|min:1',
            'ssc_start.*' => 'required',
            'ssc_end' => 'required|array|min:1',
            'ssc_end.*' => 'required',
            
            'jobrole' => 'required|array|min:1',
            'jobrole.*' => 'required|array|min:1',
            'jobrole.*.*' => 'required',
            
            'ssc_doc' => 'required|array:min:1',
            'ssc_doc.*' => 'required|mimes:jpeg,jpg,png,pdf',
            
            
            'scpwd_doc_no' => 'required',
            'scpwd_start' => 'required',
            'scpwd_end' => 'required',
            'scpwd_doc' => 'required|mimes:jpeg,jpg,png,pdf',
            'other_doc' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'resume' => 'required|mimes:jpeg,jpg,png,pdf',
            'doc_file' => 'nullable|mimes:jpeg,jpg,png,pdf',
            
        ];
        return $rules;
    }
}
