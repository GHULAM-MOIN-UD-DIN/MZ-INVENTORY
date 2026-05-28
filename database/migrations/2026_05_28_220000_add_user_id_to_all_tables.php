<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update users table with profile and shop settings
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo')->nullable();
            }
            if (!Schema::hasColumn('users', 'shop_name')) {
                $table->string('shop_name')->nullable();
            }
            if (!Schema::hasColumn('users', 'shop_logo')) {
                $table->string('shop_logo')->nullable();
            }
        });

        // Add user_id column to all operational tables (including sale_items and purchase_items)
        $tables = ['categories', 'products', 'customers', 'suppliers', 'sales', 'purchases', 'returns', 'expenses', 'sale_items', 'purchase_items'];
        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (!Schema::hasColumn($tableName, 'user_id')) {
                        $table->unsignedBigInteger('user_id')->nullable()->index();
                    }
                });
            }
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['photo', 'shop_name', 'shop_logo']);
        });

        $tables = ['categories', 'products', 'customers', 'suppliers', 'sales', 'purchases', 'returns', 'expenses', 'sale_items', 'purchase_items'];
        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (Schema::hasColumn($tableName, 'user_id')) {
                        $table->dropColumn('user_id');
                    }
                });
            }
        }
    }
};
