<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        return response()->view('sitemap', ['projects' => Project::query()->where('publishing_status', 'published')->get()], 200, ['Content-Type' => 'application/xml']);
    }
}
