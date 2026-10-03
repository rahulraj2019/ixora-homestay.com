<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteImageAssignment extends Model
{
    protected $fillable = [
        'key',
        'media_id',
    ];

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
