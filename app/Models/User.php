<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'preference',
        'is_active',
        'is_online',
        'last_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_online' => 'boolean',
            'last_active' => 'datetime',
            'is_active' => 'boolean'
        ];
    }
    
    /**
     * Get rooms where user is the first user.
     */
    public function rooms1()
    {
        return $this->hasMany(Room::class, 'user1_id');
    }
    
    /**
     * Get rooms where user is the second user.
     */
    public function rooms2()
    {
        return $this->hasMany(Room::class, 'user2_id');
    }
    
    /**
     * Get all rooms for this user.
     */
    public function rooms()
    {
        return $this->hasMany(Room::class, 'user1_id')
            ->orWhere('user2_id', $this->id);
    }
    
    /**
     * Get all messages sent by this user.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
