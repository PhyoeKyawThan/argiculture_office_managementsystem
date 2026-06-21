<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PesticideShopsLicense extends Model
{
    protected $fillable = [
        'pesticide_shop_id',
        'license_number',
        'name',
        'nrc',
        'shop_address',
        'issued_date',
        'expiry_date',
        'issued_by_user_id',
    ];

    public function shop(){
        return $this->belongsTo(PesticideShop::class, 'pesticide_shop_id');
    }

    public function issued_user(){
        return $this->belongsTo(User::class, 'issued_by_user_id');
    }

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
}
