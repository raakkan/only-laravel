<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Raakkan\OnlyLaravel\Models\PageModel;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('type')->default('page');
            $table->json('title');
            $table->json('subtitle')->nullable();
            $table->json('slug');
            $table->json('content')->nullable();
            $table->boolean('indexable')->default(true);
            $table->boolean('disabled')->default(false);
            $table->json('seo_title')->nullable();
            $table->json('seo_description')->nullable();
            $table->json('seo_keywords')->nullable();
            $table->unsignedBigInteger('template_id')->nullable();
            $table->json('settings')->nullable();
            $table->json('featured_image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('template_id')->references('id')->on('templates')->nullOnDelete();
        });

        DB::statement('CREATE UNIQUE INDEX pages_name_slug_en_unique ON pages (name, (CAST(JSON_EXTRACT(slug, "$.en") AS CHAR(255))))');
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
