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
        Schema::create('tournament_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('competition_type', ['singles', 'doubles'])->comment('シングルス/ダブルス別');
            $table->boolean('participated_qualifying')->default(false)->comment('予選に出たか');
            $table->boolean('participated_main')->default(false)->comment('本戦に出たか');
            $table->enum('entry_class_main', ['MAIN', 'QUALIFIER', 'LL', 'WC', 'SE'])->nullable()->comment('本戦の入場区分');
            $table->integer('draw_no_qualifying')->nullable()->comment('予選ドロー番号');
            $table->integer('seed_no_qualifying')->nullable()->comment('予選シード番号');
            $table->integer('draw_no_main')->nullable()->comment('本戦ドロー番号');
            $table->integer('seed_no_main')->nullable()->comment('本戦シード番号');
            $table->timestamps();
            
            // ユニーク制約
            $table->unique(['tournament_id', 'user_id', 'competition_type']);
            
            // インデックス
            $table->index(['tournament_id', 'competition_type']);
            $table->index('entry_class_main');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_users');
    }
};
