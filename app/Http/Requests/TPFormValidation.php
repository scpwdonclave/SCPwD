<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TPFormValidation extends FormRequest
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
            /* General Details */
            'organization' => 'required',
            'organization_type' => 'required',
            'establishment' => 'required',
            'landline' => 'nullable',
            'website' => 'nullable',
            "general_documents" =>[
                'required',
                'array',
            ],
            "general_documents.*"  => [
                'required',
                'distinct',
                'mimes:jpeg,jpg,png,pdf'
            ],
            
            /* CEO/MD/Head of the Organization Details */
            'ceo_name' => 'nullable',
            'ceo_email' => 'nullable|email',
            'ceo_mobile' => 'nullable|numeric',
            "ceo_documents" =>[
                'nullable',
                'array',
            ],
            "ceo_documents.*"  => [
                'nullable',
                'distinct',
                'mimes:jpeg,jpg,png,pdf'
            ],
            
            /* Authorized Signatory Info */
            'signatory_name' => 'nullable',
            'sinatory_email' => 'nullable|email',
            'signatory_mobile' => 'nullable|numeric',
            

            /*  */
        ];
        return $rules;
    }
}
