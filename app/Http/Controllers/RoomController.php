<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Show lobby page
     */
    public function showLobby()
    {
        $user = Auth::user();
        
        // Update online status
        $user->is_online = true;
        $user->last_active = now();
        $user->save();
        
        // Check if user already has an active room
        $activeRooms = Room::where(function($query) use ($user) {
            $query->where('user1_id', $user->id)
                  ->orWhere('user2_id', $user->id);
        })
        ->where('status', 'active')
        ->get();
        
        if ($activeRooms->count() > 0) {
            // Redirect to active room
            return redirect()->route('chat.room', ['id' => $activeRooms->first()->id]);
        }
        
        // Show lobby with available users/rooms
        return view('lobby', [
            'user' => $user
        ]);
    }
    
    /**
     * Find match for user
     */
    public function findMatch()
    {
        $user = Auth::user();
        
        // Check if user already has an active room
        $existingRoom = Room::where(function($query) use ($user) {
            $query->where('user1_id', $user->id)
                  ->orWhere('user2_id', $user->id);
        })
        ->where('status', 'active')
        ->first();
        
        if ($existingRoom) {
            return redirect()->route('chat.room', ['id' => $existingRoom->id]);
        }
        
        // Find available rooms that need a second user
        if ($user->preference === 'marah') {
            // User wants to get angry, find someone who wants to be shouted at
            $matchingRoom = Room::whereNull('user2_id')
                ->where('type', 'dimarahin')
                ->where('status', 'active')
                ->first();
            
            if ($matchingRoom) {
                $matchingRoom->user2_id = $user->id;
                $matchingRoom->type = 'mix';
                $matchingRoom->save();
                
                return redirect()->route('chat.room', ['id' => $matchingRoom->id]);
            }
            
            // Create a new room if no match found
            $newRoom = Room::create([
                'user1_id' => $user->id,
                'type' => 'marah',
                'status' => 'active',
                'last_activity' => now()
            ]);
            
            return redirect()->route('chat.room', ['id' => $newRoom->id]);
        } else {
            // User wants to be shouted at, find someone who wants to get angry
            $matchingRoom = Room::whereNull('user2_id')
                ->where('type', 'marah')
                ->where('status', 'active')
                ->first();
            
            if ($matchingRoom) {
                $matchingRoom->user2_id = $user->id;
                $matchingRoom->type = 'mix';
                $matchingRoom->save();
                
                return redirect()->route('chat.room', ['id' => $matchingRoom->id]);
            }
            
            // Create a new room if no match found
            $newRoom = Room::create([
                'user1_id' => $user->id,
                'type' => 'dimarahin',
                'status' => 'active',
                'last_activity' => now()
            ]);
            
            return redirect()->route('chat.room', ['id' => $newRoom->id]);
        }
    }
    
    /**
     * Close room
     */
    public function closeRoom($id)
    {
        $room = Room::findOrFail($id);
        
        // Set user yang menutup chat menjadi tidak aktif
        $user = auth()->user();
        $user->is_active = false;
        $user->save();
        
        // Hapus room
        $room->delete();
        
        return redirect()->route('preference');
    }
}
