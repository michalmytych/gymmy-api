<?php

namespace App\Models\Training;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'repetitions_count',
        'break_duration',
        'realization_id',
        'is_target',
        'weight'
    ];
}
