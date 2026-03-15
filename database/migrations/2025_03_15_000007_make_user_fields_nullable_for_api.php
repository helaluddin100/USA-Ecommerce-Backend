<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE users MODIFY company_name VARCHAR(255) NULL');
            DB::statement('ALTER TABLE users MODIFY country VARCHAR(255) NULL');
            DB::statement('ALTER TABLE users MODIFY city VARCHAR(255) NULL');
            DB::statement('ALTER TABLE users MODIFY state VARCHAR(255) NULL');
            DB::statement('ALTER TABLE users MODIFY zip VARCHAR(255) NULL');
            DB::statement('ALTER TABLE users MODIFY contact_name VARCHAR(255) NULL');
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE users MODIFY company_name VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE users MODIFY country VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE users MODIFY city VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE users MODIFY state VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE users MODIFY zip VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE users MODIFY contact_name VARCHAR(255) NOT NULL');
        }
    }
};
