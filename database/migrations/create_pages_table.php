<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->json('title');
            $table->json('subtitle')->nullable();
            $table->string('slug')->unique();
            $table->json('content')->nullable();
            $table->boolean('disabled')->default(false);
            $table->json('seo_title')->nullable();
            $table->json('seo_description')->nullable();
            $table->json('seo_keywords')->nullable();
            $table->unsignedBigInteger('template_id');
            $table->json('settings')->nullable();
            $table->string('featured_image')->nullable();
            $table->timestamps();

            $table->foreign('template_id')
                ->references('id')
                ->on('templates')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
