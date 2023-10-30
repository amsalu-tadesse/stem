<?php

namespace App\Http\Requests;

use App\Models\Organization;
use App\Models\OrganizationLevel;
use App\Models\Region;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreOrganizationRequest extends FormRequest
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
            'organization_level_id' => 'organization_level',
            'organization_type_id' => 'organization_type'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $levelIds = OrganizationLevel::pluck('id')->toArray();
        $regionIds = Region::pluck('id')->toArray();

        return [
            'name' => 'required|string',
            'description' => '',
            'organization_type_id' => ['required', 'numeric', Rule::exists('organization_types', 'id')],
            'organization_level_id' => $levelIds ? ['required', Rule::in($levelIds)] : '',
            'region_id' => (request('organization_level_id') == 2 or request('organization_level_id') == 3) ? ['required', Rule::in($regionIds)] : '',
            'zone_id' => request('organization_level_id') == 3 ? 'required' : '',
            'created_by' => '',
            'updated_by' => '',
        ];
    }
}
