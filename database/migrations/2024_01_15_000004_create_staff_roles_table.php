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
        Schema::create('transcript_staff_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('staff_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamp('assigned_at')->useCurrent();
            $table->unsignedInteger('assigned_by')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['staff_id', 'role_id']);
            
            // Add foreign key constraints
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('transcript_roles')->onDelete('cascade');
            $table->foreign('assigned_by')->references('id')->on('staff')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transcript_staff_roles');
    }
};