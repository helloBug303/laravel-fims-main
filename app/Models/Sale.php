<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'price',
        'total', // Added 'total' to fillable array for mass assignment
        'date',
    ];

    // Define the relationship between Sale and Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Calculate profit using the price from the Product model
    public function getProfitAttribute()
    {
        // Assuming that 'buy_price' and 'sale_price' are fields in the Product model
        $product = $this->product;  // Get the related product
        return ($product->sale_price - $product->buy_price) * $this->quantity;
    }

    // In Product model (Product.php)
    public function sales()
    {
        return $this->hasMany(Sale::class); // One product can have many sales
    }

    // Cast 'date' to a Carbon instance for easy manipulation
    protected $casts = [
        'date' => 'datetime',
    ];

    
}
