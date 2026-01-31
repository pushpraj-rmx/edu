<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'type',
        'publish_date',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'publish_date' => 'datetime',
            'is_active' => 'boolean',
        ];
    }
}
