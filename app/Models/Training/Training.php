<?php

namespace App\Models\Training;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Training extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'name',
        'description'
    ];

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class);
    }
}
