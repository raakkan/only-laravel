<?php

use Raakkan\ThemesManager\Models\ThemeSetting;
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
            $table->string('name');
            $table->string('label');
            $table->string('source');
            $table->json('for');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_templates');
    }
};
