<?php

namespace App\Models;

use App\Enums\SectionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    protected $fillable = [
        'page_id',
        'type',
        'content',
        'position',
        'is_active',
    ];

    /**
     * @return array<string, mixed>
     */
    protected function casts(): array
    {
        return [
            'content' => 'array',
            'is_active' => 'boolean',
            'type' => SectionType::class,
        ];
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Scope to get only active sections.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<PageSection>  $query
     * @return \Illuminate\Database\Eloquent\Builder<PageSection>
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order sections by position.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<PageSection>  $query
     * @return \Illuminate\Database\Eloquent\Builder<PageSection>
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }
}
