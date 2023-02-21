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
        Schema::create('music_dance_skills', function (Blueprint $table) {

            $table->foreignId('music_id')
                ->constrained('music')
                ->cascadeOnDelete();

            $table->foreignId('dance_id')
                ->constrained('dance_skills')
                ->cascadeOnDelete();

            $table->primary(['music_id', 'dance_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music_dance_skills');
    }
};
