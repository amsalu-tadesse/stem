<?php

namespace App\Http\Requests;

use App\Models\OrganizationLevel;
use App\Models\Region;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIssueRequest extends FormRequest
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
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // for patch request to update slider
        if (request()->ajax() and request()->isMethod('patch')) {
            return ['kpi_id' => 'required'];
        }

        // for put request to update the issue modal

        $levelIds = OrganizationLevel::pluck('id')->toArray();
        $regionIds = Region::pluck('id')->toArray();

        return [
            'title' => 'required',
            'description' => '',
            'private_benefit' => '',
            'public_benefit' => '',
            // 'responsible_institution' => '',
            // 'responsible_person'=>'required',
            // 'implementation_status'=>'required',
            // 'kpi'=>'required',
            'issue_level' => $levelIds? ['required', Rule::in($levelIds)]: '',
            'start_date'=>'',
            // 'end_date'=>'required',
            'region_id' => (request('issue_level') == 2 or request('issue_level') == 3) ? ['required', Rule::in($regionIds)] : '',
            'zone_id' => request('issue_level') == 3 ? 'required':'',
        ];
    }
}
