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
        $keepIds = DB::table('page_sections')
            ->selectRaw('MIN(id) as id')
            ->groupBy('page_id', 'type')
            ->pluck('id');

        if ($keepIds->isNotEmpty()) {
            DB::table('page_sections')->whereNotIn('id', $keepIds)->delete();
        }

        Schema::table('page_sections', function (Blueprint $table) {
            $table->unique(['page_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_sections', function (Blueprint $table) {
            $table->dropUnique(['page_id', 'type']);
        });
    }
};
