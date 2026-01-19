<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AiEditorTransformRequest
 *
 * Validates AI editor actions like rewrite/expand/shorten.
 */
final class AiEditorTransformRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'entity' => ['required', 'string', 'max:50'],              // society, project, property, etc.
            'type'   => ['required', 'string', 'max:80'],              // residential_plots...
            'action' => ['required', 'string', 'in:rewrite,expand,shorten'],
            'text'   => ['required', 'string', 'min:5', 'max:8000'],
        ];
    }
}
