# Role-Based Authentication System

## User Roles

The system supports 4 different user roles:

1. **super_admin** - Full system access, can manage all users and settings
2. **admin** - Admin dashboard access, can manage customers, orders, and products
3. **user** - Regular B2B customer, can place orders and view their account
4. **block_user** - Blocked users, cannot access the system

## User Registration Fields

Based on StyleKorean registration form, the following fields are included:

### Company Information (Required)
- Company name *
- Country *
- Email * (valid email)
- Website URL
- Phone No. (including country code)
- Fax No.
- Address
- City *
- State *
- Zip *

### Contact Information
- Contact Name *
- Position

### Account Information
- Username * (minimum 5 characters)
- Password *

### Business Information
- Type of Business * (Retailer, Wholesaler, On-line shop, Off-line shop, Network sales, SNS sales)
- Registration Path * (StyleKorean, Google, Instagram/Facebook, Tiktok, Recommendation, Others)
- Interesting Business (Kpop, Kbeauty) - Multiple selection
- Introduce

### Legal
- NDA Agreement * (must be accepted)

## Registration Process

1. User fills out registration form
2. User account is created with `role = 'user'` and `is_active = false`
3. Sales team reviews and approves account
4. User receives email confirmation
5. User can then login and access the system

## Using Role Middleware

Protect routes with role-based access:

```php
Route::middleware(['auth', 'role:super_admin,admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
});
```

## User Model Methods

```php
$user->isSuperAdmin();      // Check if super admin
$user->isAdmin();           // Check if admin
$user->isUser();            // Check if regular user
$user->isBlocked();         // Check if blocked
$user->hasAdminAccess();    // Check if has admin access (super_admin or admin)
$user->isApproved();        // Check if account is approved
```

## Seeding Default Users

Run the seeder to create default users:

```bash
php artisan db:seed --class=UserSeeder
```

Default users:
- **superadmin** / password (super_admin)
- **admin** / password (admin)
- **user** / password (user)

## Migration

Run migrations to create the updated users table:

```bash
php artisan migrate:fresh --seed
```

**Note:** This will drop all existing tables and recreate them. Use with caution in production!

