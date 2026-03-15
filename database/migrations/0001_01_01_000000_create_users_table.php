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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Authentication fields
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            // Role-based access control
            $table->enum('role', ['super_admin', 'admin', 'user', 'block_user'])->default('user');

            // Company Information
            $table->string('company_name');
            $table->string('country');
            $table->string('website_url')->nullable();
            $table->string('phone_no')->nullable(); // Including country code
            $table->string('fax_no')->nullable();
            $table->text('address')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip');

            // Contact Information
            $table->string('contact_name');
            $table->string('position')->nullable();

            // Business Information
            $table->enum('type_of_business', [
                'retailer',
                'wholesaler',
                'online_shop',
                'offline_shop',
                'network_sales',
                'sns_sales'
            ])->nullable();

            $table->enum('registration_path', [
                'stylekorean',
                'google',
                'instagram_facebook',
                'tiktok',
                'recommendation',
                'others'
            ])->nullable();

            // Interests (can be multiple, stored as JSON or comma-separated)
            $table->json('interesting_business')->nullable(); // ['kpop', 'kbeauty']

            // Additional Information
            $table->text('introduce')->nullable();

            // NDA Agreement
            $table->boolean('nda_agreement')->default(false);
            $table->timestamp('nda_agreed_at')->nullable();

            // Account Status
            $table->boolean('is_active')->default(true);
            $table->timestamp('approved_at')->nullable(); // When sales team approves
            $table->text('approval_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
