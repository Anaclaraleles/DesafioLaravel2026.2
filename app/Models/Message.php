<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'message',
        'reply',
        'replied_by',
        'replied_at',
    ];
 
    protected $casts = [
        'replied_at' => 'datetime',
    ];
 
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
 
    public function repliedByAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'replied_by');
    }
 
    /** Indica se a mensagem já foi respondida.  */
    public function getIsAnsweredAttribute(): bool
    {
        return ! is_null($this->replied_at);
    }
}
