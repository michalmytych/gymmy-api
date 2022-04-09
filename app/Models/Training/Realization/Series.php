<?php

namespace App\Models\Training\Realization;

use App\Traits\Models\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Series extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'repetitions_count',
        'realization_id',
        'weight_kg'
    ];
}
