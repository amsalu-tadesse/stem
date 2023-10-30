<?php

namespace App\Http\Requests;

use App\Models\Organization;
use App\Models\OrganizationLevel;
use App\Models\Region;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIssueRequest extends FormRequest
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
            'region_id' => 'region',
            'zone_id' => 'zone',
            // 'cityadmin_id' => 'city administration'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        if (request()->ajax()) {
            return [
                'file' => 'required',
                'issue_document_id' => 'required',
            ];
        }

        $levelIds = OrganizationLevel::pluck('id')->toArray();
        $regionIds = Region::pluck('id')->toArray();

        return [
            'title' => 'required',
            'issue_id' => 'required|numeric',
            'description' => '',
            'private_benefit' => '',
            'public_benefit' => '',
            'responsible_institution' => '',

            'responsible_person' => '',
            'kpi' => '',
            'issue_level' => ['required', Rule::in($levelIds)],
            'start_date' => '',
            'end_date' => '',
            'region_id' => (request('issue_level') == 2 or request('issue_level') == 3) ? ['required', Rule::in($regionIds)] : '',
            'zone_id' => (request('issue_level') == 3) ? 'required' : '',
            'created_by' => '',
            'updated_by' => '',
        ];
    }
}
