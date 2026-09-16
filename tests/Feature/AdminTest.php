<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_guest_is_redirected_from_admin(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_admin_can_login_and_logout(): void
    {
        $user = User::query()->firstOrFail();

        $this->post('/admin/login', ['email' => $user->email, 'password' => env('ADMIN_PASSWORD', 'ChangeMe123!')])->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
        $this->post('/admin/logout')->assertRedirect('/admin/login');
        $this->assertGuest();
    }

    public function test_admin_can_publish_a_project(): void
    {
        $project = Project::query()->firstOrFail();
        $project->update(['publishing_status' => 'draft']);

        $this->actingAs(User::query()->firstOrFail())->put(route('admin.projects.update', $project), [
            'project_category_id' => $project->project_category_id, 'name' => $project->name, 'slug' => $project->slug,
            'short_description' => $project->short_description, 'problem' => $project->problem, 'solution' => $project->solution,
            'project_status' => $project->project_status, 'publishing_status' => 'published', 'sort_order' => 1,
            'features_text' => implode("\n", $project->features), 'technologies_text' => implode("\n", $project->technologies),
        ])->assertSessionHasNoErrors()->assertRedirect();

        $this->assertDatabaseHas('projects', ['id' => $project->id, 'publishing_status' => 'published']);
    }

    public function test_admin_can_replace_resume_with_a_valid_pdf(): void
    {
        Storage::fake('public');
        $profile = Profile::query()->firstOrFail();

        $this->actingAs(User::query()->firstOrFail())->put(route('admin.profile.update'), [
            'name' => $profile->name, 'title' => $profile->title, 'tagline' => $profile->tagline,
            'summary' => $profile->summary, 'email' => $profile->email,
            'resume' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
        ])->assertSessionHasNoErrors();

        Storage::disk('public')->assertExists(Profile::query()->value('resume_path'));
    }

    public function test_admin_can_manage_project_categories(): void
    {
        $admin = User::query()->firstOrFail();

        $this->actingAs($admin)->post(route('admin.content.store', 'project-categories'), [
            'name' => 'Internal Tools',
            'slug' => 'internal-tools',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('project_categories', ['slug' => 'internal-tools']);
    }
}
