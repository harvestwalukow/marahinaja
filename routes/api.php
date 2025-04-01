<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OnlineCountController;
use App\Http\Controllers\Api\MatchingController;

Route::middleware('api')->group(function () {
    Route::get('/online-count', [OnlineCountController::class, 'count']);
    Route::get('/matching/check', [MatchingController::class, 'check']);
}); 