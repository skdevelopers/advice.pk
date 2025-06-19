<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'heading'          => 'required|string|max:255',
            'detail'           => 'required|string',
            'title'            => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:blogs,slug',
            'meta_keywords'    => 'nullable|string',
            'meta_description' => 'nullable|string',
            'domain'           => 'nullable|string|max:100',
            'image'            => 'nullable|image|max:2048',
        ];
    }
}
