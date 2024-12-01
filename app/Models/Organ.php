<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Organ extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'organ_type'
    ];

    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class);
    }
}
