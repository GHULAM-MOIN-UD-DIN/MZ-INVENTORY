<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fix categories: drop solo unique on 'name', add composite unique on ['name', 'user_id']
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique('categories_name_unique');
            $table->unique(['name', 'user_id'], 'categories_name_user_unique');
        });

        // Fix products: drop solo unique on 'code', add composite unique on ['code', 'user_id']
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique('products_code_unique');
            $table->unique(['code', 'user_id'], 'products_code_user_unique');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique('categories_name_user_unique');
            $table->unique('name', 'categories_name_unique');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique('products_code_user_unique');
            $table->unique('code', 'products_code_unique');
        });
    }
};
