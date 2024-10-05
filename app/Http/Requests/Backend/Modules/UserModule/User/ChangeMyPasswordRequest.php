<?php

namespace App\Http\Requests\Backend\Modules\UserModule\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangeMyPasswordRequest extends FormRequest
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
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Override the failedValidation method to customize the response
        throw new \Illuminate\Validation\ValidationException($validator);
    }

}
