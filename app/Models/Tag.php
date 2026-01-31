<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
    ];

    public function offerings(): BelongsToMany
    {
        return $this->belongsToMany(Offering::class);
    }
}
