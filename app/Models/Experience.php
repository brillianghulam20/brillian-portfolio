<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['company', 'position', 'started_at', 'ended_at', 'is_current', 'description', 'responsibilities', 'technologies', 'sort_order', 'is_published'])]
class Experience extends Model
{
    protected function casts(): array
    {
        return ['started_at' => 'date', 'ended_at' => 'date', 'is_current' => 'boolean', 'is_published' => 'boolean', 'responsibilities' => 'array', 'technologies' => 'array'];
    }
}
