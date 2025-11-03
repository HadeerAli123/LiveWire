<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'username' => 'required|string|exists:users,username',
            'password' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'The  Username is required.',
            'username.string' => 'The  Username must be a string.',
            'password.required' => 'The Password is required.',
            'username.exists' => 'The Username does not exist.',
        ];
    }
}
