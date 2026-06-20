<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('storage_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('related_type')->nullable();
            $table->unsignedBigInteger('related_id')->nullable();
            $table->string('disk')->default('minio');
            $table->string('bucket');
            $table->string('path');
            $table->string('filename');
            $table->string('mime_type');
            $table->integer('size');
            $table->enum('visibility', ['public', 'private'])->default('private');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index(['related_type', 'related_id']);
            $table->index('bucket');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('storage_files');
    }
};
