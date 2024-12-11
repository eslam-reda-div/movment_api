<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notes',
        'is_active',
        'location',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'location' => 'array',
    ];

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    public function paths(): HasMany
    {
        return $this->hasMany(Path::class, 'to');
    }

    public function pathsFrom(): HasMany
    {
        return $this->hasMany(Path::class, 'from');
    }

    public function pathsTo(): HasMany
    {
        return $this->hasMany(Path::class, 'to');
    }
}
