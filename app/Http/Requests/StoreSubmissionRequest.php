<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isStudent() === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => ['nullable', 'file', 'max:10240'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'link' => ['nullable', 'url', 'max:1000'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (! $this->hasFile('file') && ! $this->hasFile('photo') && ! $this->filled('link')) {
            $this->merge(['submission_missing' => true]);
        }
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            if ($this->boolean('submission_missing')) {
                $validator->errors()->add('submission', 'Kirim file, foto, atau link tugas.');
            }
        });
    }
}
