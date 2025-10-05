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
        Schema::table('student_trans', function (Blueprint $table) {
            $table->enum('category', ['student', 'institutional'])->nullable()->after('application_status');
            $table->enum('type', ['physical', 'e-copy'])->nullable()->after('category');
            $table->enum('destination', ['local', 'international'])->nullable()->after('type');
            $table->enum('courier', ['dhl', 'zcarex', 'couples'])->nullable()->after('destination');
            $table->string('institution_name')->nullable()->after('courier');
            $table->string('ref_no')->nullable()->after('institution_name');
            $table->string('institutional_phone')->nullable()->after('ref_no');
            $table->string('institutional_email')->nullable()->after('institutional_phone');
            $table->integer('number_of_copies')->default(1)->after('institutional_email');
            $table->text('delivery_address')->nullable()->after('number_of_copies');
            $table->text('purpose')->nullable()->after('delivery_address');
            $table->decimal('total_amount', 10, 2)->default(0)->after('purpose');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_trans', function (Blueprint $table) {
            $table->dropColumn([
                'category', 'type', 'destination', 'courier', 'institution_name',
                'ref_no', 'institutional_phone', 'institutional_email',
                'number_of_copies', 'delivery_address', 'purpose', 'total_amount'
            ]);
        });
    }
};
