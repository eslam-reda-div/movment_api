<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function destinations(): HasMany
    {
        return $this->hasMany(Destination::class);
    }

    public function paths(): HasMany
    {
        return $this->hasMany(Path::class);
    }
}
