<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'category',
        'description',
        'created_date'
    ];

    protected $casts = [
        'created_date' => 'date',
        'price' => 'decimal:2'
    ];

    /**
     * Get the sales for the product.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Get the total value of the product (price * quantity)
     */
    public function getTotalValueAttribute()
    {
        return $this->price * $this->quantity;
    }

    /**
     * Get the stock status
     */
    public function getStockStatusAttribute()
    {
        if ($this->quantity == 0) {
            return 'Out of Stock';
        } elseif ($this->quantity < 10) {
            return 'Low Stock';
        } else {
            return 'In Stock';
        }
    }

    /**
     * Get the stock status badge class
     */
    public function getStockStatusClassAttribute()
    {
        if ($this->quantity == 0) {
            return 'danger';
        } elseif ($this->quantity < 10) {
            return 'warning';
        } else {
            return 'success';
        }
    }

    /**
     * Get total sales amount for this product
     */
    public function getTotalSalesAttribute()
    {
        return $this->sales()->sum('total_amount');
    }

    /**
     * Get total quantity sold for this product
     */
    public function getTotalQuantitySoldAttribute()
    {
        return $this->sales()->sum('quantity_sold');
    }

    /**
     * Check if product has sufficient stock for sale
     */
    public function hasSufficientStock($quantity): bool
    {
        return $this->quantity >= $quantity;
    }
}
