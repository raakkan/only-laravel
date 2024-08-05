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
            $table->json('for');
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('theme_template_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('source')->index();
            $table->integer('order')->default(1);
            $table->json('settings')->nullable();
            $table->json('locations')->default(json_encode(['default']));
            $table->string('location')->default('default');
            $table->timestamps();

            $table->unsignedBigInteger('template_id');
            $table->foreign('template_id')->references('id')->on('theme_templates')->onDelete('cascade');

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('menu_id')->references('id')->on('theme_menus')->onDelete('cascade');
        });

        Schema::create('theme_template_block_components', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('source')->index();
            $table->integer('order')->default(1);
            $table->string('type');
            $table->string('location')->default('default');
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('block_id');
            $table->foreign('block_id')->references('id')->on('theme_template_blocks')->onDelete('cascade');

            $table->unique(['order', 'block_id', 'location']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_templates');
        Schema::dropIfExists('theme_template_blocks');
        Schema::dropIfExists('theme_template_block_components');
    }
};
