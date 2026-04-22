<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:pdf,docx|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'file.mimes' => 'Only PDF and DOCX files are allowed.',
            'file.max'   => 'Maximum file size: 10MB.',
        ];
    }
}
