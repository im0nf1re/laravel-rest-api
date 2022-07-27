<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Courier extends Model
{
    use HasFactory;

    public function hours(): BelongsToMany
    {
        return $this->belongsToMany(Hour::class, 'hour_courier');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function regions(): BelongsToMany
    {
        return $this->belongsToMany(Region::class, 'region_courier');
    }


}
