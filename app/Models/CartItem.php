<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'unit_price',
        'total',
    ];
 
    protected static function booted(): void
    {
        // Sempre recalcula o total
        static::saving(function (CartItem $item) {
            $item->total = $item->unit_price * $item->quantity;
        });
    }
 
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
 
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
