<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'buyer_id',
        'total',
        'status',
        'reference_id',
        'items',
    ];
 
    protected $casts = [
        'total' => 'decimal:2',
        'items' => 'array',
    ];
 
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
