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
        Schema::create('interviews', function (Blueprint $table) {
            $table->uuid('interview_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('finalized')->default(false);
            $table->string('level')->nullable();
            $table->string('role')->nullable();
            $table->json('techstack')->nullable();
            $table->string('type')->nullable();
            $table->json('questions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
