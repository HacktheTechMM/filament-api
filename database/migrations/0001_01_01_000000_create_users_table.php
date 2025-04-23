<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('bio')->nullable();
            $table->string('url')->nullable();
            $table->string('role')->default(User::ROLE_DEFAULT);
            $table->timestamp('email_verified_at')->nullable();
            //socialite login
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('provider_token', 255)->nullable();
            $table->string('provider_avatar')->nullable();

            $table->string('password');
            $table->string('specialization')->nullable();
            $table->string('current_level')->nullable();
            $table->string('tech_stack')->nullable();
            $table->integer('last_roadmap_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
