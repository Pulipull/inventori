<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integration_webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->string('event_name');
            $table->json('payload');
            $table->string('status');
            $table->timestamp('received_at');
            $table->timestamps();

            $table->index(['status', 'received_at']);
            $table->index(['source', 'event_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integration_webhook_logs');
    }
};
