<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class PortfolioController extends Controller
{
    public function home(): View
    {
        return view('portfolio.home', $this->sharedData() + ['projects' => $this->projects()->where('is_featured', true)->limit(3)->get()]);
    }

    public function about(): View
    {
        return view('portfolio.about', $this->sharedData());
    }

    public function experience(): View
    {
        return view('portfolio.experience', $this->sharedData());
    }

    public function skills(): View
    {
        return view('portfolio.skills', $this->sharedData());
    }

    public function contact(): View
    {
        return view('portfolio.contact', $this->sharedData());
    }

    /** @return array<string, mixed> */
    private function sharedData(): array
    {
        return ['profile' => Profile::query()->first(), 'experiences' => Experience::query()->where('is_published', true)->orderBy('sort_order')->get(), 'educations' => Education::query()->orderBy('sort_order')->get(), 'skillCategories' => SkillCategory::query()->with('skills')->orderBy('sort_order')->get(), 'certificates' => Certificate::query()->orderBy('sort_order')->get()];
    }

    private function projects(): Builder
    {
        return Project::query()->with('category')->where('publishing_status', 'published')->orderBy('sort_order');
    }
}
