<?php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AdmindekanController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DetailpeminjamanController;
use App\Http\Controllers\DistribusiController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengadaanController;

use Illuminate\Routing\RouteGroup;

use RealRashid\SweetAlert\Facades\Alert;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('index');
});


Auth::routes();


//Jenis

Route::prefix('jenis')->group(function () {
    Route::get('/',[JenisController::class, 'index'])->name('jenis.index');
    Route::get('/create',[JenisController::class, 'create'])->name('jenis.create');
    Route::post('/store',[JenisController::class, 'store'])->name('jenis.store');
    Route::get('/{id}/edit',[JenisController::class, 'edit'])->name('jenis.edit');
    Route::post('/{id}/update',[JenisController::class, 'update'])->name('jenis.update');
    Route::get('/destroy/{id}',[JenisController::class, 'destroy'])->name('jenis.destroy');

});

//Barang

Route::prefix('barang')->group(function () {
    Route::get('/',[BarangController::class, 'index'])->name('barang.index');
    Route::get('/create',[BarangController::class, 'create'])->name('barang.create');
    Route::post('/store',[BarangController::class, 'store'])->name('barang.store');
    Route::get('/{id}/edit',[BarangController::class, 'edit'])->name('barang.edit');
    Route::post('/{id}/update',[BarangController::class, 'update'])->name('barang.update');
    Route::get('/destroy/{id}',[BarangController::class, 'destroy'])->name('barang.destroy');

});

//Aset

Route::prefix('aset')->group(function () {
    Route::get('/',[AsetController::class, 'index'])->name('aset.index');
    Route::get('/create',[AsetController::class, 'create'])->name('aset.create');
    Route::post('/store',[AsetController::class, 'store'])->name('aset.store');
    Route::get('/{id}/edit',[AsetController::class, 'edit'])->name('aset.edit');
    Route::post('/{id}/update',[AsetController::class, 'update'])->name('aset.update');
    Route::get('/destroy/{id}',[AsetController::class, 'destroy'])->name('aset.destroy');

});


//Pengadaan

Route::prefix('pengadaan')->group(function () {
    Route::get('/',[PengadaanController::class, 'index'])->name('pengadaan.index');
    Route::get('/create',[PengadaanController::class, 'create'])->name('pengadaan.create');
    Route::post('/store',[PengadaanController::class, 'store'])->name('pengadaan.store');
    Route::get('/{id}/edit',[PengadaanController::class, 'edit'])->name('pengadaan.edit');
    Route::post('/{id}/update',[PengadaanController::class, 'update'])->name('pengadaan.update');
    Route::get('/destroy/{id}',[PengadaanController::class, 'destroy'])->name('pengadaan.destroy');

});



// Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

// Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

// Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');
