<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('login');
    }
    
    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $user = User::create([
            'name' => strtoupper($request->name),
            'is_active' => true,
            'last_active' => now()
        ]);
        
        Log::info('User logged in: ' . $user->name . ' (ID: ' . $user->id . ')');
        
        Auth::login($user);
        
        return redirect()->route('preference');
    }
    
    /**
     * Show preference selection page
     */
    public function showPreference()
    {
        $user = Auth::user();
        if (!$user->is_active) {
            $user->is_active = true;
            $user->last_active = now();
            $user->save();
            Log::info('User reactivated: ' . $user->name . ' (ID: ' . $user->id . ')');
        }
        return view('preference');
    }
    
    /**
     * Save user preference
     */
    public function savePreference(Request $request)
    {
        $request->validate([
            'preference' => 'required|in:marah,dimarahin'
        ]);
        
        $user = Auth::user();
        Log::info('Saving preference for user: ' . $user->name . ' (ID: ' . $user->id . ')');
        Log::info('Current preference: ' . $user->preference);
        Log::info('New preference: ' . $request->preference);
        
        $user->preference = $request->preference;
        $user->is_active = true;
        $user->last_active = now();
        $user->save();
        
        Log::info('User preference saved: ' . $user->name . ' - ' . $request->preference);
        Log::info('User active status: ' . ($user->is_active ? 'true' : 'false'));
        
        return response()->json([
            'success' => true,
            'message' => 'Preference saved successfully'
        ]);
    }
    
    /**
     * Logout
     */
    public function logout()
    {
        $user = Auth::user();
        $user->is_active = false;
        $user->save();
        
        Log::info('User logged out: ' . $user->name . ' (ID: ' . $user->id . ')');
        
        Auth::logout();
        Session::flush();
        
        return redirect()->route('login');
    }
}
