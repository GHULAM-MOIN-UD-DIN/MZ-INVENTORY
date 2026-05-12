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
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('cash_received', 15, 2)->default(0)->after('grand_total');
            $table->decimal('change_return', 15, 2)->default(0)->after('cash_received');
            $table->decimal('service_charge', 15, 2)->default(1.00)->after('change_return');
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['cash_received', 'change_return', 'service_charge']);
        });
    }
};
