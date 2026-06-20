<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integration_outbox_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->string('aggregate_type')->nullable();
            $table->unsignedBigInteger('aggregate_id')->nullable();
            $table->json('payload');
            $table->enum('status', ['pending', 'processed', 'failed'])->default('pending');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['aggregate_type', 'aggregate_id']);
            $table->index('event_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integration_outbox_events');
    }
};
