<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class StaffLog extends Model
{
    use HasFactory;

    protected $table = 'staff_logs';

    protected $fillable = [
        'staff_id',
        'action',
        'changes',
        'user_id',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }

    public function modifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function actionLabel(): Attribute
    {
        return Attribute::get(function () {
            $key = 'messages.staff_log.' . $this->action;
            $label = __($key);

            if ($label !== $key) {
                return $label;
            }

            return Str::title(str_replace('_', ' ', (string) $this->action));
        });
    }

    protected function actionBadgeClass(): Attribute
    {
        return Attribute::get(fn () => match ($this->action) {
            'created' => 'bg-emerald-100 text-emerald-900',
            'updated_profile' => 'bg-blue-100 text-blue-900',
            'promoted_demoted' => 'bg-amber-100 text-amber-900',
            'transferred' => 'bg-violet-100 text-violet-900',
            'deleted' => 'bg-red-100 text-red-900',
            default => 'bg-slate-100 text-slate-700',
        });
    }

    protected function formattedChanges(): Attribute
    {
        return Attribute::get(function ($value, array $attributes) {
            $changes = $this->resolveChangesPayload($attributes['changes'] ?? null);
            $rows = [];

            if (isset($changes['initial_data']) && is_array($changes['initial_data'])) {
                foreach ($changes['initial_data'] as $field => $value) {
                    $rows[] = [
                        'field' => $this->translateField($field),
                        'old' => __('messages.common.em_dash'),
                        'new' => $this->formatValue($value),
                    ];
                }

                return $rows;
            }

            if (isset($changes['initial_snapshot']) && is_array($changes['initial_snapshot'])) {
                foreach ($changes['initial_snapshot'] as $field => $value) {
                    $rows[] = [
                        'field' => $this->translateField($field),
                        'old' => __('messages.common.em_dash'),
                        'new' => $this->formatValue($value),
                    ];
                }

                return $rows;
            }

            foreach ($changes as $field => $delta) {
                if (in_array($field, ['initial_data', 'initial_snapshot'], true)) {
                    continue;
                }

                if (is_array($delta) && array_key_exists('old', $delta) && array_key_exists('new', $delta)) {
                    $rows[] = [
                        'field' => $this->translateField($field),
                        'old' => $this->formatValue($delta['old']),
                        'new' => $this->formatValue($delta['new']),
                    ];
                } elseif (! is_array($delta)) {
                    $rows[] = [
                        'field' => $this->translateField($field),
                        'old' => __('messages.common.em_dash'),
                        'new' => $this->formatValue($delta),
                    ];
                }
            }

            return $rows;
        });
    }

    private function translateField(string $field): string
    {
        $key = 'messages.staff.fields.'.$field;
        $label = __($key);

        return $label !== $key ? $label : Str::title(str_replace('_', ' ', $field));
    }

    private function resolveChangesPayload(mixed $raw): array
    {
        if (is_array($raw)) {
            return $raw;
        }

        if (is_string($raw)) {
            $decoded = json_decode($raw, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    private function formatValue(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? __('messages.common.yes') : __('messages.common.no');
        }

        if ($value === null || $value === '' || $value === '—') {
            return __('messages.common.em_dash');
        }

        return (string) $value;
    }
}
