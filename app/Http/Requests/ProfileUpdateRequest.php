<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'fname' => ['nullable', 'string', 'max:120'],
            'lname' => ['nullable', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:50', Rule::unique('users')->ignore($this->user()->id)],
            'bio' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
        ];
    }
}
