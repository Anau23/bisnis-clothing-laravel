<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cash_drawers', function (Blueprint $table) {
            $table->id();

            // siapa kasir yang pegang laci
            $table->foreignId('cashier_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('drawer_number')->nullable();

            // saldo
            $table->decimal('opening_balance', 15, 2);
            $table->decimal('expected_cash', 15, 2)->default(0);
            $table->decimal('actual_cash', 15, 2)->nullable();
            $table->decimal('difference', 15, 2)->nullable();

            // status
            $table->enum('status', ['open', 'reconciled', 'closed'])
                ->default('open');

            // waktu
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('closed_at')->nullable();

            // catatan reconcile
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_drawers');
    }
};
