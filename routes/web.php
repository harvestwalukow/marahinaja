<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OnlineCountController;
use App\Http\Controllers\Api\MatchingController;
use Illuminate\Support\Facades\Broadcast;

// Broadcast Auth
Broadcast::routes(['middleware' => ['auth']]);

// Auth routes
Route::get('/', function() {
    return view('welcome');
})->name('home');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Preference
    Route::get('/preference', [LoginController::class, 'showPreference'])->name('preference');
    Route::post('/preference', [LoginController::class, 'savePreference'])->name('preference.save');
    
    // Chat
    Route::get('/chat/{id}', [ChatController::class, 'showRoom'])->name('chat.room');
    Route::post('/chat/{roomId}/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/{roomId}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/{id}/close', [RoomController::class, 'closeRoom'])->name('chat.close');

    // API Routes
    Route::get('/api/online-count', [OnlineCountController::class, 'count']);
    Route::get('/api/matching/check', [MatchingController::class, 'check']);
});

// AI Wizard route (coming soon)
Route::get('/ai-wizard', function() {
    return view('ai-wizard');
})->name('ai.wizard');
