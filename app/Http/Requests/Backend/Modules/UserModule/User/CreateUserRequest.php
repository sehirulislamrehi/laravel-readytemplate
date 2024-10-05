<?php

namespace App\Http\Requests\Backend\Modules\UserModule\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'required|numeric',
            'password' => 'required|confirmed',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Override the failedValidation method to customize the response
        throw new \Illuminate\Validation\ValidationException($validator);
    }

}
