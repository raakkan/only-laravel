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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('label')->nullable();
            $table->json('settings')->nullable();
            $table->string('type')->default('page');
            $table->json('parent_block_access')->nullable();
            $table->boolean('is_parent')->default(false);
            $table->unsignedBigInteger('parent_template_id')->nullable();
            $table->foreign('parent_template_id')->references('id')->on('templates')->onDelete('set null');
            $table->timestamps();

            $table->unique(['name', 'type'], 'unique_templates');
        });

        Schema::create('template_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->boolean('disabled')->default(false);
            $table->integer('order')->default(1);
            $table->json('settings')->nullable();
            $table->string('location')->default('default');
            $table->enum('type', ['block', 'component']);

            $table->unsignedBigInteger('template_id');
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade');

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('template_blocks')->onDelete('cascade');

            $table->unique(['order', 'template_id', 'location', 'parent_id'], 'unique_template_blocks');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
        Schema::dropIfExists('template_blocks');
    }
};
