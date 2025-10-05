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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_trans_id');
            // Foreign key will be added separately after checking data types
            $table->string('rrr')->unique()->nullable(); // Remita Retrieval Reference
            $table->decimal('amount', 10, 2);
            $table->string('transaction_status')->default('Pending'); // Pending, RRR_Generated, Successful, Failed
            $table->string('payment_method')->nullable(); // remita, paystack, etc.
            $table->string('transaction_reference')->nullable(); // External payment reference
            $table->timestamp('payment_date')->nullable();
            $table->json('payment_response')->nullable(); // Store API response
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['student_trans_id', 'transaction_status']);
            $table->index('rrr');
            $table->index('transaction_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
