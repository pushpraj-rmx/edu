<?php

namespace Tests\Feature;

use App\Enums\SectionType;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CmsPageSeoAndSectionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_page_includes_seo_meta_tags(): void
    {
        $page = Page::create([
            'title' => 'Test Page',
            'slug' => 'test-page',
            'meta_title' => 'SEO Title',
            'meta_description' => 'SEO description for the page.',
            'is_homepage' => true,
            'layout' => 'public',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<title>SEO Title</title>', false);
        $response->assertSee('name="description" content="SEO description for the page."', false);
        $response->assertSee('property="og:title" content="SEO Title"', false);
        $response->assertSee('property="og:type" content="website"', false);
        $response->assertSee('rel="canonical"', false);
    }

    public function test_inactive_sections_are_not_rendered_on_public_page(): void
    {
        $page = Page::create([
            'title' => 'Home',
            'slug' => 'home',
            'is_homepage' => true,
            'layout' => 'public',
            'is_active' => true,
        ]);

        PageSection::create([
            'page_id' => $page->id,
            'type' => SectionType::RichText,
            'content' => ['heading' => null, 'body' => 'Visible content'],
            'position' => 0,
            'is_active' => true,
        ]);

        PageSection::create([
            'page_id' => $page->id,
            'type' => SectionType::RichText,
            'content' => ['heading' => null, 'body' => 'Hidden content'],
            'position' => 1,
            'is_active' => false,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Visible content');
        $response->assertDontSee('Hidden content');
    }

    public function test_hero_section_media_upload_stores_file_and_persists_path(): void
    {
        $user = \App\Models\User::factory()->create();
        $page = Page::create([
            'title' => 'Test',
            'slug' => 'test',
            'is_homepage' => false,
            'layout' => 'public',
            'is_active' => true,
        ]);

        $image = \Illuminate\Http\UploadedFile::fake()->image('hero.jpg', 100, 100);

        $response = $this->actingAs($user)->post(route('pages.sections.store', $page), [
            'type' => 'hero',
            'content' => [
                'badge' => '',
                'title' => 'Hero',
                'highlight_phrase' => '',
                'subtitle' => '',
                'primary_cta_text' => '',
                'primary_cta_url' => '',
                'secondary_cta_text' => '',
                'secondary_cta_url' => '',
            ],
            'is_active' => true,
            'content_image_file' => $image,
        ]);

        $response->assertRedirect(route('pages.edit', $page));
        $section = $page->sections()->where('type', SectionType::Hero)->first();
        $this->assertNotNull($section);
        $this->assertArrayHasKey('image', $section->content);
        $this->assertStringStartsWith('hero/', $section->content['image']);
        $this->assertTrue(\Illuminate\Support\Facades\Storage::disk('public')->exists($section->content['image']));
    }
}
