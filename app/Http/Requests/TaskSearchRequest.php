<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskSearchRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|string|max:255',
            'sort' => 'nullable|in:asc,desc',
            'per_page' => 'nullable|integer|min:1',
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
