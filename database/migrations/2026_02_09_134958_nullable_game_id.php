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
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('game_id')->nullable()->change();

            $table->foreign('game_id')
                ->references('id')
                ->on('games')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('game_id')->nullable(false)->change();

            $table->foreign('game_id')
                ->references('id')
                ->on('games')
                ->cascadeOnDelete();
        });
    }
};
