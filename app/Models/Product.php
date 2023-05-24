<?php

namespace App\Models;

use App\Models\User;
use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /******************** RELATIONSHIPS ******************/  

     /**
     * Get the reviews of the product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the user that added the product.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
