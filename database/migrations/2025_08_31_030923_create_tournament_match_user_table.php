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
        Schema::create('tournament_match_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_match_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('side', ['side_a', 'side_b']);
            $table->enum('result', ['win', 'lose']);
            $table->timestamps();

            $table->index(['tournament_match_id', 'side']);
            $table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_match_user');
    }
};
