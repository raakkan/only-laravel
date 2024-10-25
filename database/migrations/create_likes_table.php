<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('user_id');
            $table->morphs('likeable');
            $table->boolean('is_like')->default(true)->comment('true for like, false for unlike');
            $table->timestamps();

            $table->unique(['user_id', 'likeable_id', 'likeable_type'], 'user_likeable_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
