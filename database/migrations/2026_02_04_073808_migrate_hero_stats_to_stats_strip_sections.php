<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('page_sections')) {
            return;
        }

        $now = Carbon::now();

        $heroSections = DB::table('page_sections')
            ->where('type', 'hero')
            ->select(['id', 'page_id', 'content', 'position', 'is_active'])
            ->get();

        foreach ($heroSections as $hero) {
            $content = json_decode($hero->content ?? '[]', true);
            if (! is_array($content)) {
                $content = [];
            }

            $stats = $content['stats'] ?? null;
            $stats = is_array($stats) ? array_values($stats) : [];
            $stats = array_values(array_filter($stats, fn ($s) => ! empty($s['value'] ?? $s['label'] ?? null)));

            unset($content['stats']);

            DB::table('page_sections')
                ->where('id', $hero->id)
                ->update([
                    'content' => json_encode($content),
                    'updated_at' => $now,
                ]);

            if (count($stats) === 0) {
                continue;
            }

            $statsStripExists = DB::table('page_sections')
                ->where('page_id', $hero->page_id)
                ->where('type', 'stats_strip')
                ->exists();

            if ($statsStripExists) {
                continue;
            }

            $insertPosition = ((int) $hero->position) + 1;

            DB::table('page_sections')
                ->where('page_id', $hero->page_id)
                ->where('position', '>=', $insertPosition)
                ->increment('position');

            DB::table('page_sections')->insert([
                'page_id' => $hero->page_id,
                'type' => 'stats_strip',
                'content' => json_encode([
                    'stats' => array_slice($stats, 0, 4),
                ]),
                'position' => $insertPosition,
                'is_active' => (bool) $hero->is_active,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('page_sections')) {
            return;
        }

        $now = Carbon::now();

        $statsStrips = DB::table('page_sections')
            ->where('type', 'stats_strip')
            ->select(['id', 'page_id', 'content', 'position'])
            ->get();

        foreach ($statsStrips as $strip) {
            $hero = DB::table('page_sections')
                ->where('page_id', $strip->page_id)
                ->where('type', 'hero')
                ->select(['id', 'content'])
                ->first();

            if ($hero) {
                $heroContent = json_decode($hero->content ?? '[]', true);
                if (! is_array($heroContent)) {
                    $heroContent = [];
                }

                if (! array_key_exists('stats', $heroContent)) {
                    $stripContent = json_decode($strip->content ?? '[]', true);
                    if (! is_array($stripContent)) {
                        $stripContent = [];
                    }

                    $heroContent['stats'] = $stripContent['stats'] ?? [];

                    DB::table('page_sections')
                        ->where('id', $hero->id)
                        ->update([
                            'content' => json_encode($heroContent),
                            'updated_at' => $now,
                        ]);
                }
            }

            $deletedPosition = (int) $strip->position;

            DB::table('page_sections')->where('id', $strip->id)->delete();

            DB::table('page_sections')
                ->where('page_id', $strip->page_id)
                ->where('position', '>', $deletedPosition)
                ->decrement('position');
        }
    }
};
