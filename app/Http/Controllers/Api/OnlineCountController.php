<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OnlineCountController extends Controller
{
    public function count(): JsonResponse
    {
        try {
            // Set user yang tidak aktif dalam 5 menit terakhir menjadi offline
            User::where('is_active', true)
                ->where('updated_at', '<', Carbon::now()->subMinutes(5))
                ->update(['is_active' => false]);

            $count = User::where('is_active', true)->count();
            Log::info('Online users count: ' . $count);
            
            // Debug query
            $query = User::where('is_active', true)->toSql();
            Log::info('SQL Query: ' . $query);
            
            return response()->json([
                'count' => $count,
                'success' => true
            ]);
        } catch (\Exception $e) {
            Log::error('Error counting online users: ' . $e->getMessage());
            return response()->json([
                'count' => 0,
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 