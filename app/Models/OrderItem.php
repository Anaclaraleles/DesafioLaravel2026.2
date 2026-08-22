<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'sub_total',
        'seller_id',
    ];
 
    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'sub_total' => 'decimal:2',
    ];
 
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
 
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
 
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
