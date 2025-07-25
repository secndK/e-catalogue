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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('mat_ag')->unique(); // matricule de l'agent
            $table->string('nom_ag'); // nom de l'agent
            $table->string('pren_ag'); // prenom de l'agent
            $table->string('email')->unique(); // email de l'agent
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('dir_ag'); // direction de l'agent
            $table->string('loc_ag'); // localisation de l'agent
            $table->string('sta_ag')->nullable(); // statut de l'agent
            $table->string('role')->nullable(); // rôle de l'agent
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
