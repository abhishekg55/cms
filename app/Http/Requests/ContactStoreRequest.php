<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
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
            'profile_image' => 'required|image|mimes:png,jpg',
            'field_names' => 'required_with:field_values|array',
            'field_values' => 'required_with:field_names|array',
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
            'profile_image.required' =>  'Please choose Profile Image',
            'profile_image.image' =>  'choose valid Profile Image',
            'profile_image.mimes' =>  'choose Profile Image of type JPG,PNG',
            'field_names.required_with' => 'please enter field name',
            'field_values.required_with' => 'please enter field value'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
