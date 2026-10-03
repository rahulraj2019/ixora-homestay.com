<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactEnquiry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message', 'status', 'admin_notes', 'ip_address',
    ];
}
