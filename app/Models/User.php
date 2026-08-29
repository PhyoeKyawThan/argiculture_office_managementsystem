<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'staff_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_SHOP = 'shop';

    public const ROLE_STAFF = 'staff';

    public const ROLE_FARMER = 'farmer';

    public const ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_SHOP,
        self::ROLE_FARMER,
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isBackOffice(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_STAFF], true);
    }

    public function isShop(): bool
    {
        return $this->role === self::ROLE_SHOP;
    }

    public function isFarmer(): bool
    {
        return $this->role === self::ROLE_FARMER;
    }

    public function hasRole(string|array $roles): bool
    {
        $roles = is_array($roles) ? $roles : func_get_args();

        return in_array($this->role, $roles, true);
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => __('messages.roles.admin'),
            self::ROLE_SHOP => __('messages.roles.shop'),
            self::ROLE_STAFF => __('messages.roles.staff'),
            self::ROLE_FARMER => __('messages.roles.farmer'),
            default => ucfirst((string) $this->role),
        };
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }

    public function agriculturalInquiries(): HasMany
    {
        return $this->hasMany(AgriculturalInquiry::class);
    }

    public function agriculturalAnnouncements(): HasMany
    {
        return $this->hasMany(AgriculturalAnnouncement::class);
    }

    public function fertilizerDistributionLicenses(): HasMany
    {
        return $this->hasMany(FertilizerDistributionLicense::class);
    }

    public function pesticideShop(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PesticideShop::class);
    }
}
