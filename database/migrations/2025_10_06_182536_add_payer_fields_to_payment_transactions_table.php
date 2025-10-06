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
        Schema::table('payment_transactions', function (Blueprint $table) {
            $table->string('order_id')->nullable()->after('transaction_reference');
            $table->string('payer_name')->nullable()->after('order_id');
            $table->string('payer_email')->nullable()->after('payer_name');
            $table->string('payer_phone')->nullable()->after('payer_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_transactions', function (Blueprint $table) {
            $table->dropColumn(['order_id', 'payer_name', 'payer_email', 'payer_phone']);
        });
    }
};
