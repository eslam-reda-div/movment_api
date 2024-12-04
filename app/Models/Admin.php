<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasApiTokens, HasFactory, HasPanelShield, HasRoles, Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
        'phone_number',
        'notes',
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
}
