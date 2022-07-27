<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public function couriers(): BelongsTo
    {
        return $this->belongsTo(Courier::class);
    }

    public function hours(): BelongsToMany
    {
        return $this->belongsToMany(Hour::class);
    }

    public function regions(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
