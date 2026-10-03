<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlockItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'page_block_id', 'title', 'subtitle', 'description', 'image', 'link',
        'button_label', 'button_url', 'extra_json', 'sort_order', 'status',
    ];

    protected function casts(): array
    {
        return [
            'extra_json' => 'array',
        ];
    }

    public function block(): BelongsTo
    {
        return $this->belongsTo(PageBlock::class, 'page_block_id');
    }
}
