<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('order_number', 64)->index();
            $table->string('payment_method', 50)->default('eps');
            $table->string('gateway_name', 50)->default('eps');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('USD');
            $table->string('status', 20)->default('pending'); // pending, paid, failed, cancelled
            $table->string('transaction_id', 255)->nullable();
            $table->json('raw_callback')->nullable(); // full callback/request data from gateway
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};
