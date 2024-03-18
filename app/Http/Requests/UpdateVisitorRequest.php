<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVisitorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'institution_id' => '',
            'institution_type_id' => '',
            'country_id' => '',
            'created_from' => '',
            'actual_visitor' => 'required',
            'visitor_count' => '',
            'responsible_person' => '',
            'phone' => '',
            'description' => '',
            'email' => '',
            'visiting_hr' => '',
            'appointment_date' => ''
        ];
    }
}
