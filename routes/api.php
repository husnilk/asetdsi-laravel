<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\PjController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\OngoingController;
use App\Http\Controllers\Api\PengusulanController;
use App\Http\Controllers\Api\MediaController;

Route::group(['middleware' => ['auth:sanctum']], function () {    
    Route::get('/setting', [SettingController::class, 'index']);
    Route::put('/editprofile', [SettingController::class, 'editprofile']);
    Route::put('/changepassword', [SettingController::class, 'changepassword']);
    Route::get('/barang',[BarangController::class,'index']);
    Route::get('/daftarbarang',[BarangController::class,'daftarBarang']);
    Route::get('/pj-peminjaman',[PjController::class,'index']);
    Route::get('/pj-pengusulan',[PjController::class,'indexpengusulan']);
    Route::get('/daftarpeminjaman-barang/{id}',[PeminjamanController::class,'index']);
    Route::get('/daftarpeminjaman-bangunan/{id}',[PeminjamanController::class,'indexBangunan']);
    Route::get('/history',[HistoryController::class,'index']);
    Route::get('/ongoing',[OngoingController::class,'index']);
    Route::get('/historypengusulan',[HistoryController::class,'indexPengusulan']);
    Route::get('/ongoingpengusulan',[OngoingController::class,'indexPengusulan']);
    Route::get('/showpeminjaman/{id}',[HistoryController::class,'show']);
    Route::get('/showongoingpeminjaman/{id}',[OngoingController::class,'show']);
    Route::get('/showhistorypengusulan/{id}',[HistoryController::class,'showpengusulan']);
    Route::get('/showhistorypengusulanmt/{id}',[HistoryController::class,'showpengusulanmt']);
    Route::get('/showbukti/{id}',[HistoryController::class,'showbukti']);
    Route::get('/showongoingpengusulan/{id}',[OngoingController::class,'showpengusulan']);
    Route::get('/showongoingpengusulanmt/{id}',[OngoingController::class,'showpengusulanmt']);
    Route::get('/showbuktiongoing/{id}',[OngoingController::class,'showbukti']);
    Route::post('/storepengusulan/{id}',[PengusulanController::class,'store']);
    Route::post('/storeBarang/{id}',[PeminjamanController::class,'storeBarang']);
    Route::post('/storeBangunan/{id}',[PeminjamanController::class,'storeBangunan']);
    Route::get('/barangmt/{id}',[PengusulanController::class,'index']);
    Route::post('/uploadfoto',[MediaController::class,'upload']);
    Route::post('/storepengusulanmt/{id}',[PengusulanController::class,'storemt']);
});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register',[AuthController::class, 'register']);
