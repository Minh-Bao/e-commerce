<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [];
     
    /******************** RELATIONSHIPS ******************/  

    /**
     * Get the product that owns the review.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the user that made the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

     /******************** SCOPE ******************/ 

    /**
     * Scope a query to only include popular users.
     *
     * @param Builder $query
     * @param integer $rate
     * @return integer
     */
    public function scopeRates(Builder $query,int $rate): int
    {
        return $query->where('rating', $rate)->get()->count();
    }

}
