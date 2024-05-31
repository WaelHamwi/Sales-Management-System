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
        Schema::create('products', function (Blueprint $table) {
          $table->id();
          $table->string('name', 120);
          $table->string('price', 19);
          $table->string('sku', 64);
          $table->string('barcode', 48);
          $table->string('image', 100)->nullable();
          $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade');
          $table->foreignId('company_id')->references('id')->on('companies')->onDelete('cascade');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
