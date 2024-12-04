<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Path extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'stops',
        'domain_id',
        'company_id',
        'from',
        'to',
        'name',
        'notes',
    ];

    protected $casts = [
        'stops' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function fromDestination(): BelongsTo
    {
        return $this->belongsTo(Destination::class, 'from');
    }

    public function toDestination(): BelongsTo
    {
        return $this->belongsTo(Destination::class, 'to');
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
