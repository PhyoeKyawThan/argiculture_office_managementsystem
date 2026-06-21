<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesticideShop extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_APPROVED,
        self::STATUS_REJECTED,
    ];

    protected $fillable = [
        'user_id',
        'name',
        'township',
        'nrc',
        'education',
        'stable_address',
        'requested_selling_address',
        'building_type',
        'building_area',
        'from_restaurant_distance',
        'retail_or_wholesale',
        'has_emergency_preparedness_plan',
        'signature',
        'attachments',
        'surrounding_agreements',
        'status',
        'rejection_reason',
        'reviewed_by',
    ];

    protected $casts = [
        'attachments' => 'array',
        'surrounding_agreements' => 'array',
        'has_emergency_preparedness_plan' => 'boolean',
    ];
    protected function nrc(): Attribute
    {
        return Attribute::make(
            get: function (string $value) {
                if (preg_match('/^([^\(]+\([^\)]+\))\s*[^\(]+(\([^\)]+\)\d+)$/u', $value, $matches)) {
                    return $matches[1] . $matches[2];
                }

                if (preg_match('/^([^\s\(]+)\s*(\([^\)]+\))[^\(]+(\([^\)]+\)\d+)/u', $value, $matches)) {
                    return $matches[1] . $matches[2] . $matches[3];
                }

                return $value;
            }
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }
}
