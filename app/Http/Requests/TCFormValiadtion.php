<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TCFormValiadtion extends FormRequest
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
            'spoc_name' => 'required',
            'email' => 'required|email|unique:centers',
            'spoc_mobile' => 'required|regex:/[0-9]{10}/|unique:partners',

            /* Address of the Organization */
            'org_name' => 'nullable',
            'org_address' => 'required',
            'landmark' => 'required',
            'addr_proof' => 'required',
            'addr_doc' => 'required|mimes:jpeg,jpg,png,pdf',
            'city' => 'required',
            'block' => 'required',
            'pin' => 'required|numeric|digits:6',
            'state_district' => 'required',
            'parliament' => 'required',
            /* End Address of the Organization */

            /* File Pickers */
            'addr_doc' => 'required|mimes:jpeg,jpg,png,pdf',
            'center_front_view' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'center_back_view' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'center_right_view' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'center_left_view' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'bio_room' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'drink_room' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'saftey' => 'nullable|mimes:jpeg,jpg,png,pdf',
            
            "class_room" => 'nullable|array',
            'class_room.*' => 'nullable|distinct|mimes:jpeg,jpg,png,pdf',
            "lab_room" => 'nullable|array',
            'lab_room.*' => 'nullable|distinct|mimes:jpeg,jpg,png,pdf',
            "equipment_room" => 'nullable|array',
            'equipment_room.*' => 'nullable|distinct|mimes:jpeg,jpg,png,pdf',
            "wash_room" => 'nullable|array',
            'wash_room.*' => 'nullable|distinct|mimes:jpeg,jpg,png,pdf',
            /* End File Pickers */
        ];

        return $rules;
    }
}
