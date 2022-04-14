<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Training\Training;
use Illuminate\Notifications\Notifiable;
use App\Models\Training\Exercise\Exercise;
use App\Models\Training\Realization\Realization;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class);
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class);
    }

    public function realizations(): HasMany
    {
        return $this->hasMany(Realization::class);
    }
}
