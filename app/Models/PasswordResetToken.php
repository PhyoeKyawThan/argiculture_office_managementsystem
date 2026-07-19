<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['email', 'token', 'created_at'])]
class PasswordResetToken extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';
    protected $primaryKey = 'email';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }
}
