<?php

namespace App\Models;

use App\Models\User;
use App\Models\Review;
use App\Models\Pivots\ProductUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * Get all the buyers of the product.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_user', 'product_id', 'user_id')
                    ->withTimestamps()
                    ->using(ProductUser::class);
    }

    /**
     * Get a owner of a product
     *
     * @return BelongsToMany
     */
    public function user(int $id): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_user', 'product_id', 'user_id')
                    ->as('owner')
                    ->wherePivot('product_id', $this->id)
                    ->wherePivot('user_id', $id)
                    ->withTimestamps()
                    ->using(ProductUser::class);
    }
}
