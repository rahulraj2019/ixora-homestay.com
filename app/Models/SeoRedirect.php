<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoRedirect extends Model
{
    protected $fillable = ['old_url', 'new_url', 'type', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'type' => 'integer',
        ];
    }
}
