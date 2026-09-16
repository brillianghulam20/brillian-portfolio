<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Contracts\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('projects.index', ['profile' => Profile::query()->first(), 'projects' => Project::query()->with('category')->where('publishing_status', 'published')->orderBy('sort_order')->get(), 'categories' => ProjectCategory::query()->has('projects')->orderBy('name')->get()]);
    }

    public function show(Project $project): View
    {
        abort_unless($project->publishing_status === 'published' || auth()->check(), 404);
        $related = Project::query()->where('publishing_status', 'published')->where('project_category_id', $project->project_category_id)->whereKeyNot($project->id)->limit(2)->get();

        return view('projects.show', ['profile' => Profile::query()->first(), 'project' => $project->load('category'), 'related' => $related]);
    }
}
