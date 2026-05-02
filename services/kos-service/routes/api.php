<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\PemilikController;

Route::middleware('jwt')->group(function () {

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

// Fasilitas 
Route::get('/fasilitas', [FasilitasController::class, 'index']);
Route::get('/fasilitas/{id}', [FasilitasController::class, 'show']);
Route::post('/fasilitas', [FasilitasController::class, 'store']);
Route::put('/fasilitas/{id}', [FasilitasController::class, 'update']);
Route::delete('/fasilitas/{id}', [FasilitasController::class, 'destroy']);

// Pemilik
Route::get('/pemilik', [PemilikController::class, 'index']);
Route::get('/pemilik/{id}', [PemilikController::class, 'show']);    
Route::post('/pemilik', [PemilikController::class, 'store']);
Route::put('/pemilik/{id}', [PemilikController::class, 'update']);
Route::delete('/pemilik/{id}', [PemilikController::class, 'destroy']);  

});