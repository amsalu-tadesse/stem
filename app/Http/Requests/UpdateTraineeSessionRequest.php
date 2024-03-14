<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTraineeSessionRequest extends FormRequest
{
    /**
     * Determine if the row is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => '',
            'academic_year' => '',
            'objective' => '',
            'start_date' => '',
            'end_date' => '',
            'status' => '',
            'center_id' => '',
            'group_id' => '',
            'fund_type_id' => '',
        ];
    }
}
