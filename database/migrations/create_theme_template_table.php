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
            $table->string('name')->index();
            $table->string('label');
            $table->string('source')->index();
            $table->json('for');
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('theme_template_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('label');
            $table->string('source')->index();
            $table->integer('order')->default(1);
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('template_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('theme_template_blocks')->onDelete('cascade');
            $table->foreign('template_id')->references('id')->on('theme_templates')->onDelete('cascade');

            $table->unique(['order', 'parent_id']);
        });

        Schema::create('theme_template_block_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('label');
            $table->string('source')->index();
            $table->integer('order')->default(1);
            $table->string('type');
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('block_id');
            $table->foreign('block_id')->references('id')->on('theme_template_blocks')->onDelete('cascade');

            $table->unique(['order', 'block_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_templates');
        Schema::dropIfExists('theme_template_blocks');
        Schema::dropIfExists('theme_template_block_items');
    }
};
