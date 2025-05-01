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
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->string('title', 100);
            $table->string('content');
            $table->string('status')->default('to-do');
            $table->json('attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['title', 'created_at']);
            $table->index(['content', 'created_at']);
            $table->index(['status', 'created_at']);
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
