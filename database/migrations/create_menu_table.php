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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('location')->nullable();
            $table->boolean('disabled')->default(false);
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id');
            $table->string('name');
            $table->string('label')->nullable();
            $table->integer('order')->default(1);
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();
    
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('menu_items')->onDelete('cascade');

            $table->unique(['order', 'menu_id', 'parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
        Schema::dropIfExists('menu_items');
    }
};
