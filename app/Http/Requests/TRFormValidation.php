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

            'doc_no' => 'requierd',
            
            /* TR Basic Details */
            'name' => 'requierd',
            'email' => 'requierd|email',
            'mobile' => 'requierd|numeric',
            /* End TR Basic Details */
            
            /* Authorized Signatory Info */
            'sector' => 'required|array|min:1',
            'sector.*' => 'required',
            'ssc_doc' => 'required|mimes:jpeg,jpg,png,pdf',
            'ssc_doc_no' => 'required|mimes:jpeg,jpg,png,pdf',

            'signatory_email' => 'nullable|email',
            'signatory_mobile' => 'nullable|numeric|digits:10',
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
            'ssc_doc' => 'required|mimes:jpeg,jpg,png,pdf',
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
