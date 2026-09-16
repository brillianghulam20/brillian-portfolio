<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['institution', 'degree', 'major', 'start_year', 'end_year', 'description', 'sort_order'])]
class Education extends Model
{
    protected $table = 'educations';
}
