<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cash_drawer_logs', function (Blueprint $table) {
            $table->id();

            // relasi utama
            $table->foreignId('cash_drawer_id')
                ->constrained('cash_drawers')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // tipe transaksi
            $table->enum('transaction_type', [
                'opening',
                'closing',
                'sale',
                'cash_in',
                'cash_out',
                'adjustment',
            ]);

            // nilai uang (positif / negatif)
            $table->decimal('amount', 15, 2);

            $table->string('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_drawer_logs');
    }
};
