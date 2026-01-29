<?php

namespace App\Http\Requests\Api;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserByAdminRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->route('user'))],
            'password' => ['sometimes', 'nullable', Password::defaults()],
            'role' => ['sometimes', 'required', Rule::in(Role::values())],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The user name is required.',
            'email.required' => 'The user email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'A user with this email already exists.',
            'role.required' => 'The user role is required.',
            'role.in' => 'The selected role is invalid.',
        ];
    }
}
