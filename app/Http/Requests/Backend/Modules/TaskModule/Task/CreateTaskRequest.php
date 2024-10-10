<?php

namespace App\Http\Requests\Backend\Modules\TaskModule\Task;

use App\Enum\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTaskRequest extends FormRequest
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
               'description' => 'required',
               'status' => [
                    "required",
                    Rule::enum(TaskStatusEnum::class)
               ],
               'start_date' => 'required|date',
               'due_date' => 'required|date|after_or_equal:start_date',
               'assigned_to' => 'required|int|exists:users,id',
               'image' => 'file|mimes:jpg,png,jpeg,webp|max:1000'
          ];
     }

     protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
     {
          // Override the failedValidation method to customize the response
          throw new \Illuminate\Validation\ValidationException($validator);
     }
}
