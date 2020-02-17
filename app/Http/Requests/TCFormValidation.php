<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TCFormValidation extends FormRequest
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

            /* Address of the Organization */
            'center_name' => 'required',
            'center_address' => 'required',
            'landmark' => 'required',
            'addr_proof' => 'required',
            'addr_doc' => 'required|mimes:jpeg,jpg,png,pdf',
            'city' => 'required',
            'block' => 'required',
            'pin' => 'required|numeric|digits:6',
            'state_district' => 'required|numeric',
            'parliament' => 'required',
            /* End Address of the Organization */

            /* JOB Roles */
            "jobrole" => 'required|array',
            'jobrole.*' => 'required|distinct',

            "target" => 'required|array',
            'target.*' => 'required|numeric',

            /* End JOB Roles */

            /* File Pickers */
            'addr_doc' => 'required|mimes:jpeg,jpg,png,pdf',
            'center_front_view' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'center_back_view' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'center_right_view' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'center_left_view' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'bio' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'drink' => 'nullable|mimes:jpeg,jpg,png,pdf',
            'safety' => 'nullable|mimes:jpeg,jpg,png,pdf',
            
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
