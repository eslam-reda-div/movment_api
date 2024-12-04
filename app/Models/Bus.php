<?php

namespace App\Models;

use App\Enums\TripStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'image_url',
        'is_active',
        'notes',
        'seats_count',
        'uuid',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'is_active' => 'boolean',
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

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function activeTrip()
    {
        return $this->hasOne(Trip::class, 'driver_id', 'driver_id')
            ->where('status', TripStatus::IN_PROGRESS->value)
            ->whereDate('start_at_day', now())
            ->whereTime('start_at_time', '<=', now()->format('H:i:s'))
            ->latest();
    }

    public function hasActiveTrip(): bool
    {
        return $this->activeTrip()->exists();
    }
}
