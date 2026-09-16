<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'issuer', 'issued_at', 'credential_url', 'sort_order'])]
class Certificate extends Model
{
    protected function casts(): array
    {
        return ['issued_at' => 'date'];
    }
}
