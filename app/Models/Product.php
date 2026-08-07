<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $table = 'products';
    
    protected $fillable = [
        'id', 
        'user_id', 
        'name', 
        'price', 
        'quantity', 
        'description', 
        'category', 
        'photo'
    ];
}
