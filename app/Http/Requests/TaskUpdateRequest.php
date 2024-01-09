<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskUpdateRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (! empty($this->route('id'))) {
            $this->merge([
                'id' => $this->route('id'),
            ]);
        }
    }
    
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'bail|required|numeric|exists:tasks,id',
            'title' => 'bail|nullable|string',
            'task_status_id' => 'bail|required|numeric|exists:tasks_status,id',
            'description' => 'nullable|string',
            'ordering' =>'nullable|numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if (! is_scalar($validator->errors()->messages())) {
            $message = array_map('current', $validator->errors()->messages());
        }
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $message ?? $validator->errors(),
        ], 422));
    }
}
