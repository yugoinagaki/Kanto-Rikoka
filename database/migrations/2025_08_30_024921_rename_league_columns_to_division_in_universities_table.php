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
        Schema::table('universities', function (Blueprint $table) {
            $table->renameColumn('boys_league', 'boys_division');
            $table->renameColumn('girls_league', 'girls_division');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->renameColumn('boys_division', 'boys_league');
            $table->renameColumn('girls_division', 'girls_league');
        });
    }
};
