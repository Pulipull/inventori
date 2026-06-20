<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_delivery_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_id')->constrained('app_notifications')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('channel')->default('database');
            $table->string('status');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index(['user_id', 'created_at']);
            $table->index(['notification_id', 'channel']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_delivery_logs');
    }
};
