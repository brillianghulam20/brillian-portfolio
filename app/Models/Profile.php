<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'title', 'tagline', 'summary', 'location', 'email', 'phone', 'linkedin_url', 'github_url', 'whatsapp_url', 'photo_path', 'resume_path'])]
class Profile extends Model
{
    //
}
