<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDemoRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'team_size' => ['nullable', 'string', 'in:1-10,11-50,51-200,201+'],
            'message' => ['nullable', 'string', 'max:2000'],
        ];
    }

    protected function prepareForValidation(): void
    {
        foreach (['name', 'email', 'company', 'phone', 'message'] as $field) {
            if (is_string($this->input($field))) {
                $this->merge([
                    $field => trim($this->input($field)),
                ]);
            }
        }

    }
}
