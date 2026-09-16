<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\ProjectCategory;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContentController extends Controller
{
    private const TYPES = ['experiences' => Experience::class, 'educations' => Education::class, 'skills' => Skill::class, 'certificates' => Certificate::class, 'project-categories' => ProjectCategory::class];

    public function index(string $type): View
    {
        $model = $this->model($type);

        $orderBy = $type === 'project-categories' ? 'name' : 'sort_order';

        return view('admin.content', ['type' => $type, 'items' => $model::query()->orderBy($orderBy)->get(), 'categories' => SkillCategory::query()->orderBy('sort_order')->get()]);
    }

    public function store(Request $request, string $type): RedirectResponse
    {
        $model = $this->model($type);
        $model::query()->create($this->validated($request, $type));

        return back()->with('status', 'Konten berhasil ditambahkan.');
    }

    public function update(Request $request, string $type, int $id): RedirectResponse
    {
        $this->model($type)::query()->findOrFail($id)->update($this->validated($request, $type));

        return back()->with('status', 'Konten berhasil diperbarui.');
    }

    public function destroy(string $type, int $id): RedirectResponse
    {
        $this->model($type)::query()->findOrFail($id)->delete();

        return back()->with('status', 'Konten berhasil dihapus.');
    }

    /** @return class-string<Model> */
    private function model(string $type): string
    {
        abort_unless(isset(self::TYPES[$type]), 404);

        return self::TYPES[$type];
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, string $type): array
    {
        $rules = match ($type) {
            'experiences' => ['company' => 'required|max:160', 'position' => 'required|max:160', 'started_at' => 'nullable|date', 'ended_at' => 'nullable|date', 'is_current' => 'nullable|boolean', 'description' => 'nullable', 'responsibilities_text' => 'nullable', 'technologies_text' => 'nullable', 'sort_order' => 'required|integer|min:0', 'is_published' => 'nullable|boolean'],
            'educations' => ['institution' => 'required|max:160', 'degree' => 'required|max:160', 'major' => 'nullable|max:160', 'start_year' => 'nullable|integer', 'end_year' => 'nullable|integer', 'description' => 'nullable', 'sort_order' => 'required|integer|min:0'],
            'skills' => ['skill_category_id' => 'required|exists:skill_categories,id', 'name' => 'required|max:120', 'sort_order' => 'required|integer|min:0'],
            'certificates' => ['name' => 'required|max:200', 'issuer' => 'required|max:160', 'issued_at' => 'nullable|date', 'credential_url' => 'nullable|url', 'sort_order' => 'required|integer|min:0'],
            'project-categories' => ['name' => 'required|max:120', 'slug' => ['required', 'alpha_dash', 'max:140', Rule::unique('project_categories', 'slug')->ignore($request->route('id'))]],
        };
        $data = $request->validate($rules);
        foreach (['responsibilities', 'technologies'] as $field) {
            if (array_key_exists($field.'_text', $data)) {
                $data[$field] = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $data[$field.'_text'] ?? '') ?: [])));
                unset($data[$field.'_text']);
            }
        }
        foreach (['is_current', 'is_published'] as $field) {
            if (array_key_exists($field, $rules)) {
                $data[$field] = $request->boolean($field);
            }
        }

        return $data;
    }
}
