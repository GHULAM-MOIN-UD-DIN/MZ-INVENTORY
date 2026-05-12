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
            if (!Schema::hasColumn('sales', 'discount')) {
                $table->decimal('discount', 15, 2)->default(0)->after('grand_total');
            }
            if (!Schema::hasColumn('sales', 'tax')) {
                $table->decimal('tax', 15, 2)->default(0)->after('discount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['discount', 'tax']);
        });
    }
};
