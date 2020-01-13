<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


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
        // $request = $this->attributes->all();
        $rules = [

            /* TR Basic Details */
            'doc_no' => ['required','unique:trainers','regex:/^([a-zA-Z]){3}([0-9]){7}|^(\d){12}$/'],
            'name' => 'required',
            /* End TR Basic Details */

            'qualification' => 'required',
            'sector_exp' => 'required|numeric',
            'teaching_exp' => 'required|numeric',
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
            'qualification_doc' => 'required|mimes:jpeg,jpg,png,pdf',
            
        ];

        if ($this->prsnt) {
            $rules['email'] = [
                'required',
                'email',
                'unique:admins,email',
                'unique:trainers,email',
                'unique:partners,email',
                'unique:centers,email',
                'unique:trainer_statuses,email,'.$this->id,
                'unique:agencies,email',
                'unique:assessors,email',
            ];
            $rules['mobile'] = [
                'required',
                'numeric',
                'unique:trainers,mobile',
                'unique:partners,spoc_mobile',
                'unique:centers,mobile',
                'unique:trainer_statuses,mobile,'.$this->id,
                'unique:agencies,mobile',
                'unique:assessors,mobile',
            ];
            $rules['doc_file'] = 'nullable|mimes:jpeg,jpg,png,pdf';
        } else {
            $rules['email'] = [
                'required',
                'email',
                'unique:admins,email',
                'unique:trainers,email',
                'unique:partners,email',
                'unique:centers,email',
                'unique:trainer_statuses,email',
            ];
            $rules['mobile'] = [
                'required',
                'numeric',
                'unique:trainers,mobile',
                'unique:partners,spoc_mobile',
                'unique:centers,mobile',
                'unique:trainer_statuses,mobile',
            ];
            $rules['doc_file'] = 'required|mimes:jpeg,jpg,png,pdf';
        }        

        return $rules;
    }
}
