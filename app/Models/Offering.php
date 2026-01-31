<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Offering extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'type',
        'category_id',
        'duration',
        'eligibility',
        'intake',
        'description',
        'brochure_pdf',
        'meta_title',
        'meta_description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
