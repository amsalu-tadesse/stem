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
        return false;
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
            'visitor_count' => '|numeric|max:5000',
            'responsible_person' => '|string',
            'phone' => '',
            'email' => '|email',
            'visiting_hr' => '|string',
            'appointment_date' => ['', 'date', 'date_format:Y-m-d'],
        ];
    }
}
