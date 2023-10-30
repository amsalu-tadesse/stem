<?php

namespace App\Http\Requests;

use App\Models\FileCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    // set field names while validation
    public function attributes()
    {
        return [
            'file_category_id' => 'file_category',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $file_categories = FileCategory::pluck('id')->toArray();
        $validation = [
            'file_name' => 'required',
            'description' => '',
            'file_category_id' => ['required', $file_categories ? Rule::in($file_categories) : '' ],
            'document_id' => 'required',
        ];

        if (request()->ajax() && request()->isMethod('PATCH')) {
            return array_merge($validation, [
                'kpi_id' => 'required',
                'issue_id' => 'required'
            ]);
        }
        return $validation;
    }
}
