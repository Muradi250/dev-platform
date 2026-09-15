<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for testimonial submission.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'company' => [
                'nullable',
                'string',
                'max:255',
            ],

            'position' => [
                'nullable',
                'string',
                'max:255',
            ],

            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'rating' => [
                'nullable',
                'integer',
                'min:1',
                'max:5',
            ],

            'message' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required' =>
                'Please enter your name.',

            'name.max' =>
                'Your name may not exceed 255 characters.',

            'email.email' =>
                'Please enter a valid email address.',

            'avatar.image' =>
                'The uploaded file must be an image.',

            'avatar.mimes' =>
                'Avatar must be a JPG, JPEG, PNG, or WEBP image.',

            'avatar.max' =>
                'Avatar size may not exceed 2 MB.',

            'rating.integer' =>
                'Rating must be a valid number.',

            'rating.min' =>
                'Rating must be at least 1.',

            'rating.max' =>
                'Rating may not be greater than 5.',

            'message.required' =>
                'Please enter your testimonial.',

            'message.min' =>
                'Your testimonial must contain at least 10 characters.',

            'message.max' =>
                'Your testimonial may not exceed 2000 characters.',
        ];
    }

    /**
     * Prepare validated data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => is_string($this->name)
                ? trim($this->name)
                : $this->name,

            'email' => is_string($this->email)
                ? trim($this->email)
                : $this->email,

            'company' => is_string($this->company)
                ? trim($this->company)
                : $this->company,

            'position' => is_string($this->position)
                ? trim($this->position)
                : $this->position,

            'message' => is_string($this->message)
                ? trim($this->message)
                : $this->message,
        ]);
    }
}