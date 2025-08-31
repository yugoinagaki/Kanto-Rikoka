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
        Schema::create('league_ties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained('leagues')->onDelete('cascade');
            $table->foreignId('university_a_id')->constrained('universities');
            $table->foreignId('university_b_id')->constrained('universities');
            $table->foreignId('winner_university_id')->nullable()->constrained('universities');
            $table->foreignId('loser_university_id')->nullable()->constrained('universities');
            $table->date('tie_date')->nullable();
            $table->string('venue')->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->nullable();
            $table->timestamps();
            
            $table->index('league_id');
            $table->index(['university_a_id', 'university_b_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_ties');
    }
};
