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
        Schema::create('transcript_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // view_transcripts, manage_transcripts, view_payments, etc.
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->string('module'); // transcript, payment, admin
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transcript_permissions');
    }
};