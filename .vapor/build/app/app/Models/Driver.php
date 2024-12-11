<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\TripStatus;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasApiTokens, HasFactory, HasPanelShield, Notifiable;

    protected $guard = 'driver';

    protected $fillable = [
        'name',
        'password',
        'avatar_url',
        'phone_number',
        'notes',
        'home_address',
        'uuid',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
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

    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->avatar_url) {
            return asset('storage/'.$this->avatar_url);
        } else {
            $hash = md5(strtolower(trim($this->name)));

            return 'https://www.gravatar.com/avatar/'.$hash.'?d=mp&r=g&s=250';
        }
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return false;
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function bus(): HasOne
    {
        return $this->hasOne(Bus::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    public function activeTrip()
    {
        return $this->hasOne(Trip::class)
            ->where('status', TripStatus::IN_PROGRESS->value)
            ->whereDate('start_at_day', now())
            ->whereTime('start_at_time', '<=', now()->format('H:i:s'))
            ->latest();
    }

    public function hasActiveTrip(): bool
    {
        return $this->trips()->where('status', TripStatus::IN_PROGRESS->value)
            ->whereDate('start_at_day', now())
            ->exists();
    }
}
