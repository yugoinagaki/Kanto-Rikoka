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
        Schema::create('league_match_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_match_id')->constrained('league_matches')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('side', ['side_a', 'side_b']);
            $table->enum('result', ['win', 'lose'])->nullable();
            $table->timestamps();
            
            $table->unique(['league_match_id', 'user_id']);
            $table->index(['league_match_id', 'side']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_match_users');
    }
};
