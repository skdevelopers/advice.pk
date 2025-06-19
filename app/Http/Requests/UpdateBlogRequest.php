<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'heading'          => 'required|string|max:255',
            'detail'           => 'required|string',
            'title'            => 'required|string|max:255',
            'slug'             => [
                'required',
                'string',
                Rule::unique('blogs','slug')->ignore($this->route('blog')->id),
            ],
            'meta_keywords'    => 'nullable|string',
            'meta_description' => 'nullable|string',
            'domain'           => 'nullable|string|max:100',
            'image'            => 'nullable|image|max:2048',
        ];
    }
}
