<?php

namespace App\Http\Requests;

use App\Models\Department;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDesignationRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'department_id' => [
                'required',
                Rule::exists(
                    (new Department())->getTable(),
                    'id'
                ),
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}
