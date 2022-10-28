<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => '',
            'email' => ['required', 'email', 'string', 'max:191', Rule::unique('users')->ignore(Auth::user())],
            'username' => ['required', 'string', 'max:191', Rule::unique('users')->ignore(Auth::user())],
            'password' => ['nullable', 'string', 'confirmed', 'min:8'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->password == null) {
            $this->request->remove('password');
        }
    }
}
