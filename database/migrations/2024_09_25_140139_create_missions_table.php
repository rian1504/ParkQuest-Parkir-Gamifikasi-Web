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
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_category_id')->constrained('mission_categories')->onDelete('cascade');
            $table->foreignId('reward_id')->constrained('rewards')->onDelete('cascade');
            $table->foreignId('rank_id')->constrained('ranks')->onDelete('cascade');
            $table->string('mission_name');
            $table->text('mission_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
