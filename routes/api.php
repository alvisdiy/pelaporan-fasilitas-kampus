<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'apiLogin']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // PINDAHIN KE SINI
    Route::apiResource('laporan', LaporanController::class, ['as' => 'api']);
});