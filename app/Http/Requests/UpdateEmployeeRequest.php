<?php

namespace App\Http\Requests;

use App\Enums\EmploymentTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateEmployeeRequest extends BaseRequest
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
                'sometimes',
                'integer',
            ],

            'designation_id' => [
                'sometimes',
                'integer',
            ],

            'reporting_manager_id' => [
                'sometimes',
                'integer',
            ],

            'first_name' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'last_name' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'email' => [
                'sometimes',
                'email',
                'max:255',
            ],

            'phone' => [
                'sometimes',
                'string',
                'max:20',
            ],

            'joining_date' => [
                'sometimes',
                'date',
            ],

            'employment_type' => [
                'sometimes',
                new Enum(
                    EmploymentTypeEnum::class
                ),
            ],

            'salary' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'profile_image' => [
                'sometimes',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

            'status' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}
