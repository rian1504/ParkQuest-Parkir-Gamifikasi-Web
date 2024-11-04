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
        Schema::create('park_datas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('park_area_id')->constrained('park_areas')->onDelete('cascade');
            $table->integer('start_hour');
            $table->integer('end_hour');
            $table->integer('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('park_data');
    }
};