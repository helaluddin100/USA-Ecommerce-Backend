<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE sliders MODIFY title VARCHAR(255) NULL');
        } else {
            Schema::table('sliders', function (Blueprint $table) {
                $table->string('title')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE sliders MODIFY title VARCHAR(255) NOT NULL');
        } else {
            Schema::table('sliders', function (Blueprint $table) {
                $table->string('title')->nullable(false)->change();
            });
        }
    }
};
