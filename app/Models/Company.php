<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Company extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasApiTokens, HasFactory, HasPanelShield, Notifiable;

    protected $guard = 'company';

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
        'phone_number',
        'notes',
        'address',
        'bus_limit',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->avatar_url) {
            return asset('storage/'.$this->avatar_url);
        } else {
            $hash = md5(strtolower(trim($this->email)));

            return 'https://www.gravatar.com/avatar/'.$hash.'?d=mp&r=g&s=250';
        }
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class);
    }

    public function buses(): HasMany
    {
        return $this->hasMany(Bus::class);
    }

    public function paths(): HasMany
    {
        return $this->hasMany(Path::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
