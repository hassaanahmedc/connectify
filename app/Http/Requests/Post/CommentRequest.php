<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'posts_id' => ['required', 'integer', 'exists:posts,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'content' => ['required', 'string', 'max:2000']
        ];
    }
}
