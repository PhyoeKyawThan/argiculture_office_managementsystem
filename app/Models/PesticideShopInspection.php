<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PesticideShopInspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'inspector_staff_id',
        'owner_name',
        'shop_address',
        'township',
        'inspection_date',
        'is_registered_pesticide',
        'has_valid_retail_license',
        'license_expiry_date',
        'complies_with_pesticide_law',
        'has_training_certificate',
        'raw_findings_notes',
        'action_taken',
        'remarks',
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'license_expiry_date' => 'date',
        'is_registered_pesticide' => 'boolean',
        'has_valid_retail_license' => 'boolean',
        'complies_with_pesticide_law' => 'boolean',
        'has_training_certificate' => 'boolean',
    ];

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'inspector_staff_id', 'id');
    }
}
