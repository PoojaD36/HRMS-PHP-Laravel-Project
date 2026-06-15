<?php

namespace App\Http\Requests;

use App\Enums\EmploymentTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreEmployeeRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->normalizeBooleanFields([
            'status',
        ]);
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
                'integer',
            ],

            'designation_id' => [
                'required',
                'integer',
            ],

            'reporting_manager_id' => [
                'nullable',
                'integer',
            ],

            'first_name' => [
                'required',
                'string',
                'max:255',
            ],

            'last_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'joining_date' => [
                'nullable',
                'date',
            ],

            'employment_type' => [
                'required',
                new Enum(
                    EmploymentTypeEnum::class
                ),
            ],

            'salary' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}
