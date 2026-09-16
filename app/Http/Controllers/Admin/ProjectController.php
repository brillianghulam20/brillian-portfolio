<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.projects.index', ['projects' => Project::query()->with('category')->orderBy('sort_order')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.projects.form', ['project' => new Project(['publishing_status' => 'draft', 'project_status' => 'Case Study', 'sort_order' => 0]), 'categories' => ProjectCategory::query()->orderBy('name')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request): RedirectResponse
    {
        $project = Project::query()->create($this->data($request));

        return redirect()->route('admin.projects.edit', $project)->with('status', 'Project berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project): View
    {
        return view('admin.projects.form', ['project' => $project, 'categories' => ProjectCategory::query()->orderBy('name')->get()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($this->data($request, $project));

        return back()->with('status', 'Project berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        Storage::disk('public')->delete(array_filter(array_merge([$project->thumbnail_path, $project->architecture_path], $project->gallery ?? [])));
        $project->delete();

        return redirect()->route('admin.projects.index')->with('status', 'Project berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function data(ProjectRequest $request, ?Project $project = null): array
    {
        $data = $request->safe()->except(['features_text', 'technologies_text', 'thumbnail', 'architecture_image', 'gallery_images']);
        foreach (['features', 'technologies'] as $field) {
            $data[$field] = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $request->input($field.'_text', '')) ?: [])));
        }
        $data['is_featured'] = $request->boolean('is_featured');
        foreach (['thumbnail' => 'thumbnail_path', 'architecture_image' => 'architecture_path'] as $input => $column) {
            if ($request->hasFile($input)) {
                if ($project?->{$column}) {
                    Storage::disk('public')->delete($project->{$column});
                }
                $data[$column] = $request->file($input)->store('projects', 'public');
            }
        }
        if ($request->hasFile('gallery_images')) {
            $gallery = $project?->gallery ?? [];
            foreach ($request->file('gallery_images') as $image) {
                $gallery[] = $image->store('projects/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        return $data;
    }
}
