<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('type');
    $table->string('name');
    $table->string('code')->unique();
    $table->string('barcode_symbology');

   $table->unsignedBigInteger('category_id')->nullable();
$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');



    $table->decimal('cost', 15, 2);
    $table->decimal('price', 15, 2);
    $table->string('tax_method');
    $table->integer('quantity');
    $table->string('image')->nullable();
    $table->text('description')->nullable();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
