<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['project_category_id', 'name', 'slug', 'eyebrow', 'short_description', 'problem', 'objective', 'solution', 'role', 'business_process', 'architecture', 'challenges', 'result', 'lessons_learned', 'features', 'technologies', 'gallery', 'project_status', 'platform', 'database', 'project_year', 'thumbnail_path', 'architecture_path', 'publishing_status', 'is_featured', 'sort_order', 'seo_title', 'meta_description'])]
class Project extends Model
{
    protected function casts(): array
    {
        return ['features' => 'array', 'technologies' => 'array', 'gallery' => 'array', 'is_featured' => 'boolean'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
