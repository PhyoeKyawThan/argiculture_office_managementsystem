<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FertilizerLicenseItem extends Model
{
    protected $fillable = [
        'fertilizer_distribution_license_id',
        'fertilizer_name',
        'chemical_formula',
        'fertilizer_type',
        'packaging_size',
        'weight_volume',
    ];

    public function license(): BelongsTo
    {
        return $this->belongsTo(FertilizerDistributionLicense::class, 'fertilizer_distribution_license_id');
    }
}