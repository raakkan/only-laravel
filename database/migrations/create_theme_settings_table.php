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
        Schema::create(config('themes-manager.settings.database_table_name', 'theme_settings'), function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->json('value')->nullable();
            $table->string('source');
            $table->timestamps();
        
            $table->unique(['source', 'key']);
        });

        ThemeSetting::create([
            'key' => 'current_theme',
            'source' => 'raakkan/laravel-themes-manager',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('themes-manager.settings.database_table_name', 'theme_settings'));
    }
};
