<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->after('user_id');
            $table->string('customer_email')->nullable()->after('customer_name');
            $table->string('customer_phone')->nullable()->after('customer_email');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['customer_name', 'customer_email', 'customer_phone']);
        });
    }
};
