<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate course_categories to categories
        if (Schema::hasTable('course_categories')) {
            $courseCategories = DB::table('course_categories')->get();

            foreach ($courseCategories as $category) {
                DB::table('categories')->insert([
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'type' => 'course',
                    'created_at' => $category->created_at,
                    'updated_at' => $category->updated_at,
                ]);
            }
        }

        // Migrate courses to offerings
        if (Schema::hasTable('courses') && Schema::hasTable('categories')) {
            $courses = DB::table('courses')->get();

            foreach ($courses as $course) {
                // Find the corresponding category in the new categories table
                $oldCategory = DB::table('course_categories')->where('id', $course->course_category_id)->first();
                $newCategory = DB::table('categories')->where('slug', $oldCategory->slug ?? '')->where('type', 'course')->first();

                if ($newCategory) {
                    DB::table('offerings')->insert([
                        'title' => $course->title,
                        'slug' => $course->slug,
                        'type' => 'course',
                        'category_id' => $newCategory->id,
                        'duration' => $course->duration,
                        'eligibility' => $course->eligibility,
                        'intake' => $course->intake,
                        'description' => $course->description,
                        'brochure_pdf' => $course->syllabus_pdf, // Map syllabus_pdf to brochure_pdf
                        'meta_title' => null,
                        'meta_description' => null,
                        'created_at' => $course->created_at,
                        'updated_at' => $course->updated_at,
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove migrated data
        DB::table('offerings')->where('type', 'course')->delete();
        DB::table('categories')->where('type', 'course')->delete();
    }
};
