<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('plugins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->string('version');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('update_available')->default(false);
            $table->json('settings')->nullable();
            $table->json('custom_data')->nullable();
            $table->json('requirements_status')->nullable();
            $table->timestamp('requirements_checked_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plugins');
    }
}; 