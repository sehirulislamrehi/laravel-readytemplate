<?php

namespace App\Http\Requests\Backend\Modules\UserModule\User;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            'is_active' => 'required',
            'name' => 'required',
            'phone' => 'required|numeric',
            'role_id' => 'required|exists:roles,id',
       ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Override the failedValidation method to customize the response
        throw new \Illuminate\Validation\ValidationException($validator);
    }

}
