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
            'org_name' => 'required',
            'org_type' => 'required',
            'estab_year' => 'required|numeric|digits:4',
            'landline' => 'nullable|numeric',
            'website' => ['nullable','regex:/^((https?|ftp|smtp):\/\/)?(www.)?[a-z0-9]+(\.[a-z]{2,}){1,3}(#?\/?[a-zA-Z0-9#]+)*\/?(\?[a-zA-Z0-9-_]+=[a-zA-Z0-9-%]+&?)?$/'],
            /* End General Details */
            
            /* CEO/MD/Head of the Organization Details */
            'ceo_name' => 'nullable',
            'ceo_email' => 'nullable|email',
            'ceo_mobile' => 'nullable|numeric|min:10',
            /* End CEO/MD/Head of the Organization Details */
            
            /* Authorized Signatory Info */
            'signatory_name' => 'nullable',
            'signatory_email' => 'nullable|email',
            'signatory_mobile' => 'nullable|numeric|min:10',
            /* End Authorized Signatory Info */
            
            /* Address of the Organization */
            'org_address' => 'required',
            'landmark' => 'required',
            'addr_proof' => 'required',
            'addr_doc' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'city' => 'required',
            'block' => 'required',
            'pin' => 'required|numeric|digits:6',
            'state_district' => 'required',
            'parliament' => 'required',
            /* End Address of the Organization */

            /* Financial Information */
            'pan' => ['required','regex:/^[A-Z]{5}\d{4}[A-Z]{1}$/'],
            'pan_doc' => 'required|mimes:jpeg,jpg,png,pdf',
            'gst' => ['nullable','regex:/^([0-9]{2}[A-Z]{4}([A-Z]{1}|[0-9]{1})[0-9]{4}[A-Z]{1}([A-Z]|[0-9]){3}){0,15}$/'],
            'gst_doc' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'ca1_doc' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'ca2_doc' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'ca3_doc' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'ca4_doc' => 'nullable|mimes:jpeg,jpg,png,pdf',
            /* End Financial Information */

            /* Proposal Informatoin */
            'offer' => 'required',
            'offer_date' => 'required',
            'offer_doc' => 'required|mimes:jpeg,jpg,png,pdf',
            'sanction' => 'required',
            'sanction_date' => 'required',
            'sanction_doc' => 'required|mimes:jpeg,jpg,png,pdf',
            /* End Proposal Informatoin */
            
        ];
        return $rules;
    }
}
