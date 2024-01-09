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
        Schema::create('tasks_status', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true);
            $table->softDeletesTz('deleted_at', 3);
            $table->foreignId('deleted_by')->nullable()->constrained()->references('user_id')->on('users')->onDelete('cascade');
            $table->timestampTz('updated_at', 3)->nullable()->useCurrentOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained()->references('user_id')->on('users')->onDelete('cascade');
            $table->timestampTz('created_at', 3)->useCurrent();
            $table->foreignId('created_by')->nullable()->constrained()->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks_status');
    }
};
