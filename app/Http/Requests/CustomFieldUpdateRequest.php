<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomFieldUpdateRequest extends FormRequest
{
    public $validator = null;
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
            'field_name' => ['required', 'string', Rule::unique('custom_fields', 'field_name')->ignore(decrypt(request()->id), 'id')],
            'field_type' => ['required', Rule::in(['text', 'number', 'email', 'date'])],
            'status' => 'required|min:0|max:1',
        ];
    }

    public function messages()
    {
        return [
            'field_name.required' => 'Please enter field name',
            'field_name.unique' => request()->field_name .  ' Field already exists!',
            'field_type.required' => 'Please choose field type',
            'field_type.in' => 'Invalid field type',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
