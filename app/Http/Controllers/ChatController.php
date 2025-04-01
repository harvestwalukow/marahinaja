<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Show chat room
     */
    public function showRoom($id)
    {
        $user = Auth::user();
        $room = Room::with(['user1', 'user2'])->findOrFail($id);
        
        // Verify user belongs to this room
        if ($room->user1_id !== $user->id && $room->user2_id !== $user->id) {
            return redirect()->route('lobby')->with('error', 'Anda tidak memiliki akses ke room ini.');
        }
        
        // Get messages
        $messages = $room->messages()->with('user')->orderBy('created_at')->get();
        
        // Update room last activity
        $room->last_activity = now();
        $room->save();
        
        return view('chat', [
            'room' => $room,
            'messages' => $messages,
            'user' => $user
        ]);
    }
    
    /**
     * Send message
     */
    public function sendMessage(Request $request, $roomId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);
        
        $user = Auth::user();
        $room = Room::findOrFail($roomId);
        
        // Verify user belongs to this room
        if ($room->user1_id !== $user->id && $room->user2_id !== $user->id) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }
        
        // Create message
        $message = Message::create([
            'room_id' => $room->id,
            'user_id' => $user->id,
            'message' => $request->message,
        ]);
        
        // Load user relationship
        $message->load('user');
        
        // Update room last activity
        $room->last_activity = now();
        $room->save();
        
        // Broadcast the message
        broadcast(new MessageSent($user, $message));
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'user_id' => $user->id,
                'user_name' => $user->name
            ]
        ]);
    }
    
    /**
     * Get messages for a room
     */
    public function getMessages($roomId)
    {
        $user = Auth::user();
        $room = Room::findOrFail($roomId);
        
        // Verify user belongs to this room
        if ($room->user1_id !== $user->id && $room->user2_id !== $user->id) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }
        
        // Get last timestamp from request
        $lastTimestamp = request('last_timestamp', 0);
        
        // Get messages newer than the last timestamp
        $messages = $room->messages()
            ->with('user')
            ->when($lastTimestamp > 0, function($query) use ($lastTimestamp) {
                // Convert timestamp to UTC for comparison
                $date = \Carbon\Carbon::createFromTimestamp($lastTimestamp)->toDateTimeString();
                return $query->where('created_at', '>', $date);
            })
            ->orderBy('created_at')
            ->get()
            ->map(function($message) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'created_at' => $message->created_at->toISOString(),
                    'user_id' => $message->user_id,
                    'user' => [
                        'id' => $message->user->id,
                        'name' => $message->user->name
                    ]
                ];
            });
        
        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }
}
