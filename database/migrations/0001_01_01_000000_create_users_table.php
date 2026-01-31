<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 80)->unique()->index();
            $table->string('email', 120)->unique();
            $table->string('password');
            $table->string('role', 20); // admin | cashier
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};
