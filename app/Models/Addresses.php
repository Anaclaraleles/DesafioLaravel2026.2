<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Addresses extends Model
{
    use HasFactory;
 
    protected $table = 'addresses';
 
    protected $fillable = [
        'cep',
        'street',
        'number',
        'neighborhood',
        'city',
        'state',
        'complement',
        'user_id',
    ];
 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
