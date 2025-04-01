<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'room_id',
        'user_id',
        'message',
        'is_read',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_read' => 'boolean',
    ];
    
    /**
     * Get the room this message belongs to.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    
    /**
     * Get the user who sent this message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
