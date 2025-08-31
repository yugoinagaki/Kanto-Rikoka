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
        Schema::create('league_match_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_match_id')->constrained('league_matches')->onDelete('cascade');
            $table->tinyInteger('set_number');
            $table->tinyInteger('team_a_games');
            $table->tinyInteger('team_b_games');
            $table->tinyInteger('tiebreak_score')->nullable();
            $table->boolean('is_retired')->default(false);
            $table->timestamps();
            
            $table->index(['league_match_id', 'set_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_match_sets');
    }
};
