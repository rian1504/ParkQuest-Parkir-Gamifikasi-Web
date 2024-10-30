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
        Schema::create('park_recommendation_accepteds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('park_recommendation_id')->constrained('park_recommendations')->onDelete('cascade');
            $table->foreignId('acceptant_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('acceptant_reward_id')->constrained('rewards')->onDelete('cascade');
            $table->foreignId('recommendation_reward_id')->constrained('rewards')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('park_recommendation_accepteds');
    }
};