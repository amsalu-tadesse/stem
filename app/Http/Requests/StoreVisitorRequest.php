<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisitorRequest extends FormRequest
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
            'actual_visitor' => '',
            'visitor_count' => 'required|numeric|max:5000',
            'responsible_person' => 'required|string',
            'phone' => 'required',
            'description' => '',
            'email' => 'required|email',
            'visiting_hr' => 'required|string',
            'appointment_date' => ['required', 'date','date_format:Y-m-d']
        ];
    }
}
