<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Patient extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'patient_type',
        'blood_type'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function hospitals(): BelongsToMany
    {
        return $this->belongsToMany(Hospital::class);
    }

    public function organs(): BelongsToMany
    {
        return $this->belongsToMany(Organ::class)->withTimestamps()->using(new class extends Pivot {
            use HasUuids;
        });
    }
}
