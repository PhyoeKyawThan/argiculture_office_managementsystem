<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class AgriculturalInquiry extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_ANSWERED = 'answered';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_ANSWERED,
    ];

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'attachment_path',
        'attachment_original_name',
        'status',
        'answer_body',
        'answered_by',
        'answered_at',
    ];

    protected $casts = [
        'answered_at' => 'datetime',
    ];

    public function farmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function responder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'answered_by');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeAnswered(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ANSWERED);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isAnswered(): bool
    {
        return $this->status === self::STATUS_ANSWERED;
    }

    public function attachmentUrl(): ?string
    {
        if (! $this->attachment_path) {
            return null;
        }

        return Storage::disk('public')->url($this->attachment_path);
    }
}
