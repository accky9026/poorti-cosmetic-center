<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'brand',
        'price',
        'discount_price',
        'stock',
        'description',
        'image',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    /**
     * Final selling price (discount price if set, else regular price).
     */
    public function getFinalPriceAttribute(): float
    {
        return (float) ($this->discount_price ?? $this->price);
    }

    /**
     * Discount percentage, if a discount price is set.
     */
    public function getDiscountPercentAttribute(): ?int
    {
        if (! $this->discount_price) {
            return null;
        }

        return (int) round((($this->price - $this->discount_price) / $this->price) * 100);
    }
}
