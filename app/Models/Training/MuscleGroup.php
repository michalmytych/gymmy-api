<?php

namespace App\Models\Training;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MuscleGroup extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'name'
    ];
}
