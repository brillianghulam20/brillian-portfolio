<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillCategory;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResumeController extends Controller
{
    public function show(): View
    {
        return view('portfolio.resume', ['profile' => Profile::query()->first(), 'experiences' => Experience::query()->where('is_published', true)->orderBy('sort_order')->get(), 'educations' => Education::query()->orderBy('sort_order')->get(), 'skillCategories' => SkillCategory::query()->with('skills')->orderBy('sort_order')->get(), 'certificates' => Certificate::query()->orderBy('sort_order')->get(), 'projects' => Project::query()->where('publishing_status', 'published')->orderBy('sort_order')->get()]);
    }

    public function download(): BinaryFileResponse
    {
        $path = Profile::query()->value('resume_path');
        abort_unless($path && \Storage::disk('public')->exists($path), 404, 'CV PDF belum tersedia.');

        return response()->download(\Storage::disk('public')->path($path), 'CV-Brillian-Ghulam.pdf');
    }
}
