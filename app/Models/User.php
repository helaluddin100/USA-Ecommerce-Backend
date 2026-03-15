<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'company_name',
        'country',
        'website_url',
        'phone_no',
        'fax_no',
        'address',
        'city',
        'state',
        'zip',
        'contact_name',
        'position',
        'type_of_business',
        'registration_path',
        'interesting_business',
        'introduce',
        'nda_agreement',
        'nda_agreed_at',
        'is_active',
        'approved_at',
        'approval_notes',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'nda_agreement' => 'boolean',
            'nda_agreed_at' => 'datetime',
            'is_active' => 'boolean',
            'approved_at' => 'datetime',
            'interesting_business' => 'array',
        ];
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Check if user is blocked
     */
    public function isBlocked(): bool
    {
        return $this->role === 'block_user';
    }

    /**
     * Check if user has admin access (super_admin or admin)
     */
    public function hasAdminAccess(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    /**
     * Check if user is approved
     */
    public function isApproved(): bool
    {
        return !is_null($this->approved_at);
    }

    /**
     * Get user's full name (contact name)
     */
    public function getNameAttribute(): string
    {
        return $this->contact_name;
    }
}
