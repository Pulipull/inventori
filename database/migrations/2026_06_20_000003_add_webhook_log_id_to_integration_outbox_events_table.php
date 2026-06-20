<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('integration_outbox_events', function (Blueprint $table) {
            $table->foreignId('webhook_log_id')
                ->nullable()
                ->after('id')
                ->constrained('integration_webhook_logs')
                ->nullOnDelete();
            $table->index(['webhook_log_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('integration_outbox_events', function (Blueprint $table) {
            $table->dropIndex(['webhook_log_id', 'status']);
            $table->dropConstrainedForeignId('webhook_log_id');
        });
    }
};
