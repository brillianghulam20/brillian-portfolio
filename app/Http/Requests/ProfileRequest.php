<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'], 'title' => ['required', 'string', 'max:160'],
            'tagline' => ['required', 'string', 'max:300'], 'summary' => ['required', 'string', 'max:3000'],
            'location' => ['nullable', 'string', 'max:120'], 'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'], 'linkedin_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'], 'whatsapp_url' => ['nullable', 'url', 'max:255'],
            'photo' => ['nullable', 'image', 'max:3072'], 'resume' => ['nullable', 'mimes:pdf', 'max:5120'],
        ];
    }
}
