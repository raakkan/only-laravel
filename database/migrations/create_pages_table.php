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
            $table->string('title');
            $table->string('slug');
            $table->longText('content')->nullable();
            $table->boolean('indexable')->default(true);
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->unsignedBigInteger('template_id');
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['name', 'slug']);

            $table->foreign('template_id')->references('id')->on('templates')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
