<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'notes',
        'company_id',
        'driver_id',
        'path_id',
        'start_at_time',
        'start_at_day',
        'status',
    ];

    protected $casts = [
        'start_at_day' => 'datetime',
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

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function path()
    {
        return $this->belongsTo(Path::class);
    }
}
