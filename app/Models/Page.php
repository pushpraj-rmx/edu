<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'is_homepage',
        'layout',
        'is_active',
    ];

    /**
     * @return array<string, mixed>
     */
    protected function casts(): array
    {
        return [
            'is_homepage' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * @return HasMany<PageSection, $this>
     */
    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)->ordered();
    }

    /**
     * Get active sections for this page.
     *
     * @return HasMany<PageSection, $this>
     */
    public function activeSections(): HasMany
    {
        return $this->hasMany(PageSection::class)->active()->ordered();
    }

    /**
     * Scope to get only active pages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<Page>  $query
     * @return \Illuminate\Database\Eloquent\Builder<Page>
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the homepage.
     */
    public static function homepage(): ?self
    {
        return self::where('is_homepage', true)->active()->first();
    }
}
