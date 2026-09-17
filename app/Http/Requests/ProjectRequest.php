<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
        $projectId = $this->route('project')?->id;

        return [
            'project_category_id' => ['required', 'exists:project_categories,id'], 'name' => ['required', 'string', 'max:160'],
            'slug' => ['required', 'alpha_dash', 'max:180', 'unique:projects,slug,'.$projectId], 'eyebrow' => ['nullable', 'string', 'max:160'],
            'short_description' => ['required', 'string', 'max:600'], 'problem' => ['required', 'string'], 'objective' => ['nullable', 'string'],
            'solution' => ['required', 'string'], 'role' => ['nullable', 'string'], 'business_process' => ['nullable', 'string'],
            'architecture' => ['nullable', 'string'], 'challenges' => ['nullable', 'string'], 'result' => ['nullable', 'string'],
            'lessons_learned' => ['nullable', 'string'], 'features_text' => ['nullable', 'string'], 'technologies_text' => ['nullable', 'string'],
            'project_status' => ['required', 'string', 'max:80'], 'platform' => ['nullable', 'string', 'max:120'], 'database' => ['nullable', 'string', 'max:120'],
            'project_year' => ['nullable', 'integer', 'min:2000', 'max:2100'], 'publishing_status' => ['required', 'in:draft,published,archived'],
            'is_featured' => ['nullable', 'boolean'], 'sort_order' => ['required', 'integer', 'min:0'], 'seo_title' => ['nullable', 'string', 'max:180'],
            'meta_description' => ['nullable', 'string', 'max:320'], 'thumbnail' => ['nullable', 'image', 'max:4096'], 'architecture_image' => ['nullable', 'image', 'max:4096'],
            'remove_thumbnail' => ['nullable', 'boolean'], 'remove_architecture_image' => ['nullable', 'boolean'],
            'gallery_images' => ['nullable', 'array', 'max:10'], 'gallery_images.*' => ['image', 'max:4096'],
        ];
    }
}
