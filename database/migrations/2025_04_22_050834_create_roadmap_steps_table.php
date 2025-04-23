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
        Schema::create('roadmap_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('roadmap_id');
            $table->unsignedInteger('step_number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('resource_url')->nullable();
            $table->integer('estimated_time_minutes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roadmap_steps');
    }
};
