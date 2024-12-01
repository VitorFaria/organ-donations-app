<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'zip_code',
        'street',
        'neighbourhood',
        'state',
        'city',
        'house_number',
        'complement'
    ];

    public function hospital(): HasOne
    {
        return $this->hasOne(Hospital::class);
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }
}
