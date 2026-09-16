<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        return view('admin.dashboard', ['stats' => ['projects' => Project::query()->count(), 'published' => Project::query()->where('publishing_status', 'published')->count(), 'drafts' => Project::query()->where('publishing_status', 'draft')->count(), 'experiences' => Experience::query()->count(), 'skills' => Skill::query()->count(), 'certificates' => Certificate::query()->count()]]);
    }
}
