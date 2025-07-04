<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'content' =>  ['nullable', 'string', 'max:2000'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'removed_images' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation()
    {
        // Log the raw request data for debugging
        \Log::info('Raw request data: ', [
            'all' => $this->all(),
            'allFiles' => $this->allFiles(),
            'content' => $this->input('content'),
            'has_images' => $this->hasFile('images'),
        ]);
        // Only set default if content is not present at all
        // This way we don't overwrite empty strings or null values from the request
        if (!$this->has('content')) {
            $this->merge([
                'content' => '',
            ]);
        }
    }
}
