<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FertilizerDistributionLicense extends Model
{
    use HasFactory;
    public const STATUS_PENDING = 'pending';

    public const STATUS_ALLOWED = 'allowed';

    public const STATUS_SENDING_TO_REGIONAL_DEPARTMENT = 'sending_to_regional_department';

    public const STATUS_GOT_RESPONSE_FROM_REGIONAL_DEPARTMENT = 'got_response_from_regional_department';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_ALLOWED,
        self::STATUS_SENDING_TO_REGIONAL_DEPARTMENT,
        self::STATUS_GOT_RESPONSE_FROM_REGIONAL_DEPARTMENT,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELLED,
    ];

    protected $fillable = [
        'user_id',
        'application_date',
        'applicant_name',
        'shop_name',
        'nrc_number',
        'education_level',
        'work_experience',
        'permanent_address',
        'distribution_location_address',
        'building_type',
        'building_dimensions',
        'attachment_nrc',
        'township',
        'township_recommendation_letter',
        'status',
        'cancelled_reason'
    ];

    protected $casts = [
        'application_date' => 'date',
        'work_experience' => 'boolean',
        'attachment_nrc' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(FertilizerLicenseItem::class);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isAllowed(): bool
    {
        return $this->status === self::STATUS_ALLOWED;
    }

    public function isTransferable(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_ALLOWED], true);
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }
}