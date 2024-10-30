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
        Schema::create('park_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('park_category_id')->constrained('park_categories')->onDelete('cascade');
            $table->string('park_name');
            $table->string('park_image');
            $table->integer('park_capacity');
            $table->string('park_information');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('park_areas');
    }
};