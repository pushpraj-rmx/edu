<?php

namespace App\Enums;

enum SectionType: string
{
    case Hero = 'hero';
    case CardGrid = 'card_grid';
    case Carousel = 'carousel';
    case Testimonials = 'testimonials';
    case RichText = 'rich_text';

    public function label(): string
    {
        return match ($this) {
            self::Hero => 'Hero Section',
            self::CardGrid => 'Card Grid',
            self::Carousel => 'Carousel',
            self::Testimonials => 'Testimonials',
            self::RichText => 'Rich Text',
        };
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultContent(): array
    {
        return match ($this) {
            self::Hero => [
                'badge' => '',
                'title' => '',
                'highlight_phrase' => '',
                'subtitle' => '',
                'primary_cta_text' => '',
                'primary_cta_url' => '',
                'secondary_cta_text' => '',
                'secondary_cta_url' => '',
                'image' => null,
                'stats' => [
                    ['value' => '', 'label' => ''],
                    ['value' => '', 'label' => ''],
                    ['value' => '', 'label' => ''],
                    ['value' => '', 'label' => ''],
                ],
                'background_image' => null,
                'overlay_opacity' => 50,
                'cta_text' => '',
                'cta_url' => '',
            ],
            self::CardGrid => [
                'heading' => '',
                'subheading' => '',
                'columns' => 3,
                'cards' => [],
            ],
            self::Carousel => [
                'autoplay' => true,
                'interval' => 5,
                'slides' => [],
            ],
            self::Testimonials => [
                'heading' => '',
                'display_style' => 'slider',
                'items' => [],
            ],
            self::RichText => [
                'heading' => null,
                'body' => '',
            ],
        };
    }
}
