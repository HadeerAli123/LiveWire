<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        $userRoute = $this->route('user');
        $userId = null;
        if ($userRoute) {
            $userId = is_object($userRoute) ? $userRoute->id : $userRoute;
        }

        return [
            'username' => 'required|string|unique:users,username' . ($userId ? ',' . $userId : ''),
            'password' => 'required|string|min:8',
            'email' => 'required|email|unique:users,email' . ($userId ? ',' . $userId : ''),
            'name' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'The Username is required.',
            'username.string' => 'The Username must be a string.',
            'username.unique' => 'This Username is already taken.',

            'password.required' => 'The Password is required.',
            'password.string' => 'The Password must be a string.',
            'password.min' => 'The Password must be at least 8 characters.',

            'email.required' => 'The Email is required.',
            'email.email' => 'The Email must be a valid email address (e.g., xx@xxx.com).',
            'email.unique' => 'This Email is already registered.',

            'name.required' => 'The Name is required.',
            'name.string' => 'The Name must be a string.',
            'name.max' => 'The Name may not be greater than 255 characters.',
        ];
    }
}