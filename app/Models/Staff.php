<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'staff';

    public $incrementing = false;

    protected $keyType = 'string';
    protected $fillable = [
        'personal_no',
        'name',
        'gender',
        'date_of_birth',
        'first_joining_position',
        'first_joining_date',
        'current_position',
        'current_position_joining_date',
        'assigned_position',
        'assigned_region_first_joining_date',
        'current_region',
        'current_office',
        'current_branch',
        'education_level',
        'salary',
        'is_married',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'first_joining_date' => 'date',
        'current_position_joining_date' => 'date',
        'assigned_region_first_joining_date' => 'date',
        'is_married' => 'boolean',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(StaffLog::class, 'staff_id', 'id');
    }

    public function pesticideShopInspections(): HasMany
    {
        return $this->hasMany(PesticideShopInspection::class, 'inspector_staff_id', 'id');
    }
}