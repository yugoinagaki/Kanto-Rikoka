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
        Schema::create('tournament_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->onDelete('cascade');
            $table->enum('competition_type', ['singles', 'doubles']);
            $table->enum('format', ['one_set', 'eight_game', 'best_of_three']);
            $table->string('round', 50);
            $table->enum('status', ['scheduled', 'completed', 're_scheduled'])->nullable();
            $table->date('date')->nullable();
            $table->string('venue')->nullable();
            $table->timestamps();

            $table->index(['tournament_id']);
            $table->index(['round']);
            $table->index(['competition_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_matches');
    }
};
