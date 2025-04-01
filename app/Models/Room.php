<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'user1_id',
        'user2_id',
        'type',
        'last_activity',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_activity' => 'datetime',
    ];
    
    /**
     * Get the first user in this room.
     */
    public function user1()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }
    
    /**
     * Get the second user in this room.
     */
    public function user2()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }
    
    /**
     * Get all messages in this room.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
