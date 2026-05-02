<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PembayaranController;

// Kamar
Route::get('/kamar', [KamarController::class, 'index']);
Route::get('/kamar/{id}', [KamarController::class, 'show']);
Route::post('/kamar', [KamarController::class, 'store']);
Route::put('/kamar/{id}', [KamarController::class, 'update']);
Route::delete('/kamar/{id}', [KamarController::class, 'destroy']);

// Penyewa
Route::get('/penyewa', [PenyewaController::class, 'index']);
Route::get('/penyewa/{id}', [PenyewaController::class, 'show']);
Route::post('/penyewa', [PenyewaController::class, 'store']);
Route::put('/penyewa/{id}', [PenyewaController::class, 'update']);
Route::delete('/penyewa/{id}', [PenyewaController::class, 'destroy']);  

//Booking
Route::get('/booking', [BookingController::class, 'index']);
Route::get('/booking/{id}', [BookingController::class, 'show']);
Route::post('/booking', [BookingController::class, 'store']);
Route::put('/booking/{id}', [BookingController::class, 'update']);
Route::delete('/booking/{id}', [BookingController::class, 'destroy']);  
