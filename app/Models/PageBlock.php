<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageBlock extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'page_id', 'block_type', 'title', 'subtitle', 'content',
        'settings_json', 'sort_order', 'status',
    ];

    protected function casts(): array
    {
        return [
            'settings_json' => 'array',
        ];
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BlockItem::class)->orderBy('sort_order');
    }

    public function activeItems(): HasMany
    {
        return $this->hasMany(BlockItem::class)
            ->where('status', 'active')
            ->orderBy('sort_order');
    }
}
