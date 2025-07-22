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
        Schema::create('search_histories', function (Blueprint $table) {
            $table->id();
            $table->string('search_term');
            $table->string('user_ip')->nullable();
            $table->string('user_session')->nullable();
            $table->integer('results_count')->default(0);
            $table->timestamps();

            $table->index(['user_session', 'created_at']);
            $table->index('search_term');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_histories');
    }
};
