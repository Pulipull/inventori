<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('crm_activities', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
        });

        Schema::table('crm_activities', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->change();
            $table->foreign('customer_id')->references('id')->on('customers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('crm_activities', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
        });

        DB::table('crm_activities')->whereNull('customer_id')->delete();

        Schema::table('crm_activities', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable(false)->change();
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
        });
    }
};
