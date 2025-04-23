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
        Schema::create('mentor_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learner_id'); // Foreign key to users.id
            $table->unsignedBigInteger('mentor_id'); // Foreign key to users.id
            $table->unsignedBigInteger('subject_id'); // Foreign key to subjects.id
            $table->text('message')->nullable(); // Message text
            $table->json('requested_time'); // Requested time
            $table->string('status' )->default('pending'); // Status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor_requests');
    }
};
