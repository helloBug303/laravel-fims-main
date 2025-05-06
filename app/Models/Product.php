<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'name',
        'quantity',
        'buy_price',
        'sale_price',
        'categorie_id',
        'media_id',
        'date',
        'expiry_date',
        'expired_item'
    ];

    protected $casts = [
        'date' => 'datetime',
        'expiry_date' => 'datetime', 
    ];

    // In Product Model

    public function category()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
    

    public function isLowStock()
{
    return $this->quantity < 5;
}

public function sales()
{
    return $this->hasMany(Sale::class);
}   

}
