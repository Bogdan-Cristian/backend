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
        Schema::create('game', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->primary('id');
            $table->string('title');
            $table->string('thumbnail');
            $table->text('short_description');
            $table->string('game_url');
            $table->string('genre');
            $table->string('platform');
            $table->string('publisher');
            $table->string('developer');
            $table->string('release_date');
            $table->string('profile_url');
            $table->json('minimum_system_requirements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game');
    }
};
