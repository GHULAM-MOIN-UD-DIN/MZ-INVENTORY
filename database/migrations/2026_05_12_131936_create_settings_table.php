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
        Schema::create('settings', function (Blueprint $row) {
            $row->id();
            $row->string('shop_name')->default('MZ Inventory');
            $row->string('shop_logo')->nullable();
            $row->string('admin_name')->default('Maz Admin');
            $row->string('admin_email')->default('admin@example.com');
            $row->string('admin_photo')->nullable();
            $row->timestamps();
        });
        
        // Insert default record
        \Illuminate\Support\Facades\DB::table('settings')->insert([
            'shop_name' => 'MZ Inventory',
            'admin_name' => 'Maz Admin',
            'admin_email' => 'admin@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
