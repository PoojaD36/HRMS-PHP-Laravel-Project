<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterCompanyRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company_name'  => 'required|string|max:255',
            'company_email' => 'required|email|unique:companies,email',

            'admin_name'    => 'required|string|max:255',
            'admin_email'   => 'required|email',

            'password'      => 'required|min:8',
            'phone'         => 'nullable|string|max:20',
        ];
    }
}
