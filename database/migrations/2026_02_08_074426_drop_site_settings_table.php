<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('site_settings');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('stat_1_label')->nullable();
            $table->string('stat_1_value')->nullable();
            $table->string('stat_2_label')->nullable();
            $table->string('stat_2_value')->nullable();
            $table->string('stat_3_label')->nullable();
            $table->string('stat_3_value')->nullable();
            $table->timestamps();
        });
    }
};
