<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->double('price');
            $table->string('category', 50)->nullable(); // STRING, bukan FK
            $table->integer('stock')->default(0);
            $table->string('size', 20)->nullable();
            $table->string('color', 30)->nullable();
            $table->string('image_url', 200)->nullable();
            $table->timestamps();
        });

    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};