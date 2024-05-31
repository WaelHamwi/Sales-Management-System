<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
 {
     Schema::create('users', function (Blueprint $table) {
       $table->id();
       $table->string('first_name', 100);
       $table->string('last_name', 140);
       $table->string('email', 140)->unique();
       $table->string('password', 100);
       $table->string('image', 50)->nullable();
       $table->timestamps();
      $table->foreignId('company_id')->nullable()->references('id')->on('companies')->onDelete('cascade')->withDefault(0);
      $table->foreignId('branch_id')->nullable()->references('id')->on('branches')->onDelete('cascade')->withDefault(0);
     });
 }

 public function down()
 {
     Schema::dropIfExists('users');
 }
};
