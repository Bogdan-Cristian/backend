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
        Schema::create('system_requirement', function (Blueprint $table) {
            $table->id();
            $table->string('os');
            $table->string('processorv');
            $table->string('memory');
            $table->string('graphics');
            $table->string('storage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_requirement');
    }
};
