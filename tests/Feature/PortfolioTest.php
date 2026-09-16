<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_public_pages_render_seeded_content(): void
    {
        $this->get('/')->assertOk()->assertSee('Memahami proses.')->assertSee('WhatsApp Finance Bot');
        $this->get('/about')->assertOk()->assertSee('Brillian Ghulam Ash Shidiq');
        $this->get('/experience')->assertOk()->assertSee('PT. BEHAESTEX');
        $this->get('/skills')->assertOk()->assertSee('Requirement Gathering');
        $this->get('/projects')->assertOk()->assertSee('Document Tracking System');
        $this->get('/resume')->assertOk()->assertSee('Curriculum Vitae');
        $this->get('/contact')->assertOk()->assertSee('brillianghulam@gmail.com');
    }

    public function test_only_published_projects_are_publicly_accessible(): void
    {
        $published = Project::query()->where('publishing_status', 'published')->firstOrFail();
        $draft = Project::query()->create(array_merge($published->only(['project_category_id', 'problem', 'solution', 'project_status', 'sort_order']), ['name' => 'Private Draft', 'slug' => 'private-draft', 'short_description' => 'Draft content', 'publishing_status' => 'draft']));

        $this->get(route('projects.show', $published))->assertOk();
        $this->get(route('projects.show', $draft))->assertNotFound();
        $this->get(route('projects.index'))->assertDontSee('Private Draft');
    }

    public function test_resume_pdf_can_be_downloaded(): void
    {
        Storage::disk('public')->assertExists('resume/CV-Brillian-Ghulam.pdf');
        $this->get(route('resume.download'))->assertOk()->assertDownload('CV-Brillian-Ghulam.pdf');
    }

    public function test_sitemap_contains_published_projects(): void
    {
        $this->get('/sitemap.xml')->assertOk()->assertHeader('content-type', 'application/xml')->assertSee('/projects/document-tracking-system', false);
    }
}
