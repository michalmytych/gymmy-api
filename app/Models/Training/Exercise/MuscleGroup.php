<?php

namespace App\Models\Training\Exercise;

use App\Traits\Models\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MuscleGroup extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'name',
        'description'
    ];
}
