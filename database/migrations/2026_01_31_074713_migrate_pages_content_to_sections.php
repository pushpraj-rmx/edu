<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $pages = DB::table('pages')->whereNotNull('content')->where('content', '!=', '')->get();

        foreach ($pages as $page) {
            DB::table('page_sections')->insert([
                'page_id' => $page->id,
                'type' => 'rich_text',
                'content' => json_encode([
                    'heading' => null,
                    'body' => $page->content,
                ]),
                'position' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->longText('content')->nullable()->after('slug');
        });

        $sections = DB::table('page_sections')->where('type', 'rich_text')->get();

        foreach ($sections as $section) {
            $content = json_decode($section->content, true);
            DB::table('pages')
                ->where('id', $section->page_id)
                ->update(['content' => $content['body'] ?? '']);
        }
    }
};
