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
        Schema::create('league_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_tie_id')->constrained('league_ties')->onDelete('cascade');
            $table->string('slot_label', 10);
            $table->enum('competition_type', ['singles', 'doubles']);
            $table->enum('format', ['one_set', 'eight_game', 'best_of_three']);
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->nullable();
            $table->timestamps();
            
            $table->index(['league_tie_id', 'slot_label']);
            $table->index('competition_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_matches');
    }
};
