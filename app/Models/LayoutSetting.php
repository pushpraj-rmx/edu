<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayoutSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * @return array<string, mixed>
     */
    protected function casts(): array
    {
        return [
            'value' => 'array',
        ];
    }

    /**
     * Get a layout setting by key.
     *
     * @param  array<string, mixed>  $default
     * @return array<string, mixed>
     */
    public static function get(string $key, array $default = []): array
    {
        $setting = self::where('key', $key)->first();

        return $setting?->value ?? $default;
    }

    /**
     * Set a layout setting by key.
     *
     * @param  array<string, mixed>  $value
     */
    public static function set(string $key, array $value): self
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Get default header settings.
     *
     * @return array<string, mixed>
     */
    public static function defaultHeader(): array
    {
        return [
            'logo' => null,
            'logo_alt' => config('app.name'),
            'nav_links' => [],
            'cta_button' => [
                'text' => 'Contact Us',
                'url' => '/contact',
                'visible' => true,
            ],
        ];
    }

    /**
     * Get default footer settings.
     *
     * @return array<string, mixed>
     */
    public static function defaultFooter(): array
    {
        return [
            'about_text' => '',
            'quick_links' => [],
            'social_links' => [],
            'contact' => [
                'address' => '',
                'phone' => '',
                'email' => '',
            ],
            'copyright' => '© '.date('Y').' '.config('app.name').'. All rights reserved.',
        ];
    }
}
