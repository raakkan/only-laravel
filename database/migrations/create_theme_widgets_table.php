<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('themes-manager.widgets.location_database_table_name', 'theme_widget_locations'), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->string('source');
            $table->unique(['name', 'source']);
            $table->timestamps();
        });

        Schema::create(config('themes-manager.widgets.database_table_name', 'theme_widgets'), function (Blueprint $table) {
            $table->id();
            $table->string('widget_id');
            $table->string('name');
            $table->string('source');
            $table->integer('order')->default(1);
            $table->json('settings')->nullable();
            $table->foreignId('theme_widget_location_id')->constrained(config('themes-manager.widgets.location_database_table_name', 'theme_widget_locations'));
            $table->unique(['order', 'widget_id', 'source', 'theme_widget_location_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('themes-manager.widgets.database_table_name', 'theme_widgets'));
        Schema::dropIfExists(config('themes-manager.widgets.location_database_table_name', 'theme_widget_locations'));
    }
};
