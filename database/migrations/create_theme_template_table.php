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
        Schema::create('theme_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->unique();
            $table->string('source')->index()->unique();
            $table->string('for_theme')->default('all');
            $table->string('for_page')->default('all');
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->unique(['name', 'source']);
        });

        Schema::create('theme_template_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('source')->index();
            $table->integer('order')->default(1);
            $table->json('settings')->nullable();
            $table->string('location')->default('default');
            $table->enum('type', ['block', 'component']);

            $table->unsignedBigInteger('template_id');
            $table->foreign('template_id')->references('id')->on('theme_templates')->onDelete('cascade');

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('theme_template_blocks')->onDelete('cascade');

            $table->unique(['order', 'template_id', 'location', 'parent_id'], 'unique_theme_template_blocks');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_templates');
        Schema::dropIfExists('theme_template_blocks');
    }
};
