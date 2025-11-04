<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_number',
        'product_id',
        'quantity_sold',
        'unit_price',
        'total_amount',
        'customer_name',
        'customer_email',
        'customer_phone',
        'notes',
        'payment_method',
        'status',
        'sale_date'
    ];

    protected $casts = [
        'sale_date' => 'date',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    /**
     * Get the product that owns the sale.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Generate a unique sale number
     */
    public static function generateSaleNumber(): string
    {
        $prefix = 'SALE';
        $date = now()->format('Ymd');

        // More explicit ordering by sale_number to ensure we get the highest number
        $lastSale = static::where('sale_number', 'like', "{$prefix}{$date}%")
            ->orderBy('sale_number', 'desc')
            ->first();

        if ($lastSale) {
            $number = (int) substr($lastSale->sale_number, -4) + 1;
        } else {
            $number = 1;
        }

        $saleNumber = "{$prefix}{$date}" . str_pad($number, 4, '0', STR_PAD_LEFT);

        // Double-check uniqueness (handles race conditions)
        $maxAttempts = 5;
        $attempts = 0;

        while (static::where('sale_number', $saleNumber)->exists() && $attempts < $maxAttempts) {
            $number++;
            $saleNumber = "{$prefix}{$date}" . str_pad($number, 4, '0', STR_PAD_LEFT);
            $attempts++;
        }

        // Final fallback if still not unique
        if (static::where('sale_number', $saleNumber)->exists()) {
            $saleNumber = "{$prefix}{$date}" . substr(uniqid(), -4);
        }

        return $saleNumber;
    }

    /**
     * Update product quantity after sale
     */
    public function updateProductQuantity(): void
    {
        $product = $this->product;
        $product->quantity -= $this->quantity_sold;
        $product->save();
    }

    /**
     * Get payment method badge class
     */
    public function getPaymentMethodClassAttribute(): string
    {
        return match ($this->payment_method) {
            'cash' => 'success',
            'card' => 'primary',
            'transfer' => 'info',
            'digital' => 'warning',
            default => 'secondary'
        };
    }

    /**
     * Get status badge class
     */
    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'completed' => 'success',
            'pending' => 'warning',
            'cancelled' => 'danger',
            'refunded' => 'info',
            default => 'secondary'
        };
    }
}
