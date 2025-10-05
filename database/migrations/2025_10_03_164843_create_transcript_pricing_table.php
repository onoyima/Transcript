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
        Schema::create('transcript_pricing', function (Blueprint $table) {
            $table->id();
            $table->string('pricing_type'); // 'transcript' or 'courier'
            $table->string('application_type')->nullable(); // 'undergraduate', 'postgraduate', 'diploma', etc. (for transcript pricing)
            $table->string('delivery_type')->nullable(); // 'physical', 'e-copy' (for transcript pricing)
            $table->string('courier_name')->nullable(); // 'dhl', 'fedex', 'ups', etc. (for courier pricing)
            $table->string('destination')->nullable(); // 'local', 'international', or specific countries (for courier pricing)
            $table->decimal('price', 10, 2); // Price in Naira
            $table->text('description')->nullable(); // Optional description
            $table->boolean('is_active')->default(true); // To enable/disable pricing
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index(['pricing_type', 'application_type', 'delivery_type'], 'tp_pricing_app_delivery_idx');
            $table->index(['pricing_type', 'courier_name', 'destination'], 'tp_pricing_courier_dest_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transcript_pricing');
    }
};
