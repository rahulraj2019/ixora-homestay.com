<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'status', 'template', 'meta_title', 'meta_description',
        'canonical_url', 'robots', 'og_title', 'og_description', 'og_image',
        'twitter_title', 'twitter_description', 'twitter_image', 'sort_order',
    ];

    public function blocks(): HasMany
    {
        return $this->hasMany(PageBlock::class)->orderBy('sort_order');
    }

    public function activeBlocks(): HasMany
    {
        return $this->hasMany(PageBlock::class)
            ->where('status', 'active')
            ->orderBy('sort_order');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function isIndexable(): bool
    {
        return ! str_contains(strtolower((string) $this->robots), 'noindex');
    }
}
