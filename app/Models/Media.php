<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use SoftDeletes;

    protected $table = 'media';

    protected $fillable = [
        'disk', 'path', 'filename', 'mime_type', 'size', 'width', 'height',
        'alt', 'title', 'caption', 'folder',
    ];

    public function url(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }
}
