<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ContactUpdateRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|digits:10',
            'gender' => 'required|min:0|max:1',
            'profile_image' => 'nullable|image|mimes:png,jpg|max:2048',
            'additional_file' => 'nullable|image|mimes:png,jpg,pdf|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter name',
            'email.required' => 'Please enter email id',
            'email.email' => 'Please enter valid email id',
            'phone_number.required' => 'Please enter phone number',
            'phone_number.digits' => 'Phone number should be of 10 digits',
            'profile_image.image' =>  'choose valid Profile Image',
            'profile_image.mimes' =>  'choose Profile Image of type JPG,PNG',
            'additional_file.image' =>  'choose valid Additional File',
            'additional_file.mimes' =>  'choose Additional File of type JPG,PNG,PDF',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
