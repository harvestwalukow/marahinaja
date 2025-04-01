<?php

use App\Models\Room;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('room.{roomId}', function ($user, $roomId) {
    $room = Room::findOrFail($roomId);
    return $user->id == $room->user1_id || $user->id == $room->user2_id;
});

// Jangan gunakan presence-channel, gunakan private channel saja
Broadcast::channel('private-room.{roomId}', function ($user, $roomId) {
    $room = Room::findOrFail($roomId);
    return $user->id == $room->user1_id || $user->id == $room->user2_id;
}); 