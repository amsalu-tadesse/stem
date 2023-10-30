<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'topic'=>'required|string',
            'link'=> request()->filled('link') ? 'required|url' : '',
            'description'=>'required|string',
            'address'=>'required|string',
            'start_date'=>'required',
            'end_date'=>'required',
            'status'=>'required|numeric|max:1',
            'issue_id'=>['required', Rule::exists('issues', 'id')],
        ];
    }
}