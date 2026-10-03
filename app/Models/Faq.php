<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'question',
        'answer',
        'sort_order',
        'status',
        'show_on_home',
    ];

    protected $attributes = [
        'status' => 'active',
        'sort_order' => 0,
        'show_on_home' => false,
    ];

    protected function casts(): array
    {
        return [
            'show_on_home' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function scopeForHome(Builder $query): Builder
    {
        return $query->active()->ordered();
    }

    public function scopeForPage(Builder $query): Builder
    {
        return $query->active()->ordered();
    }
}
