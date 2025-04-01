<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MatchingController extends Controller
{
    public function check(): JsonResponse
    {
        $user = Auth::user();
        
        // Debug info
        $debug = [
            'current_user' => [
                'id' => $user->id,
                'name' => $user->name,
                'preference' => $user->preference,
                'is_active' => $user->is_active,
                'last_active' => $user->last_active
            ],
            'active_users' => User::where('is_active', true)
                ->where('id', '!=', $user->id)
                ->whereNotNull('preference')
                ->get()
                ->map(function($u) {
                    return [
                        'id' => $u->id,
                        'name' => $u->name,
                        'preference' => $u->preference,
                        'is_active' => $u->is_active,
                        'last_active' => $u->last_active
                    ];
                })
                ->toArray(),
            'matching_query' => User::where('id', '!=', $user->id)
                ->where('preference', $user->preference == 'marah' ? 'dimarahin' : 'marah')
                ->where('is_active', true)
                ->whereNotNull('preference')
                ->whereDoesntHave('rooms', function($query) {
                    $query->where('status', 'active');
                })
                ->toSql()
        ];

        // Update last_active timestamp
        $user->last_active = now();
        $user->save();
        
        // Cek apakah user sudah memiliki room aktif
        $room = Room::where(function($query) use ($user) {
            $query->where('user1_id', $user->id)
                  ->orWhere('user2_id', $user->id);
        })
        ->where('status', 'active')
        ->first();

        if ($room) {
            return response()->json([
                'success' => true,
                'matched' => true,
                'room_id' => $room->id,
                'debug' => $debug
            ]);
        }

        // Cek apakah ada partner yang cocok
        $partner = User::where('id', '!=', $user->id)
            ->where('preference', $user->preference == 'marah' ? 'dimarahin' : 'marah')
            ->where('is_active', true)
            ->whereNotNull('preference')
            ->whereDoesntHave('rooms', function($query) {
                $query->where('status', 'active');
            })
            ->first();

        if ($partner) {
            // Buat room baru
            $room = Room::create([
                'user1_id' => $user->id,
                'user2_id' => $partner->id,
                'type' => $user->preference,
                'status' => 'active',
                'last_activity' => now()
            ]);

            return response()->json([
                'success' => true,
                'matched' => true,
                'room_id' => $room->id,
                'debug' => $debug
            ]);
        }
        
        return response()->json([
            'success' => true,
            'matched' => false,
            'debug' => $debug
        ]);
    }
} 