<?php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetTypeController;
use App\Http\Controllers\AssetLocationController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\PersonInChargeController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DetailpeminjamanController;
use App\Http\Controllers\DistribusiController;
use App\Http\Controllers\JenisController;

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


Auth::routes();
//forgot Password
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');

Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');

Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// Route::get('/forgotPassword',[App\Http\Controllers\Auth\ForgotPasswordController::class, 'request'])->name('password.request');

Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/', function () {
        return view('index');
    })->name('index');

    
    //Reset Password
    Route::get('/changePassword',[App\Http\Controllers\HomeController::class, 'showChangePasswordGet'])->name('changePasswordGet');
    Route::post('/changePassword',[App\Http\Controllers\HomeController::class, 'changePasswordPost'])->name('changePasswordPost');

//Jenis
Route::prefix('jenis')->group(function () {
    Route::get('/',[AssetTypeController::class, 'index'])->name('jenis.index');
    Route::get('/create',[AssetTypeController::class, 'create'])->name('jenis.create');
    Route::post('/store',[AssetTypeController::class, 'store'])->name('jenis.store');
    Route::get('/{id}/edit',[AssetTypeController::class, 'edit'])->name('jenis.edit');
    Route::post('/{id}/update',[AssetTypeController::class, 'update'])->name('jenis.update');
    Route::get('/destroy/{id}',[AssetTypeController::class, 'destroy'])->name('jenis.destroy');

});

//Lokasi
Route::prefix('lokasi')->group(function () {
    Route::get('/',[AssetLocationController::class, 'index'])->name('lokasi.index');
    Route::get('/create',[AssetLocationController::class, 'create'])->name('lokasi.create');
    Route::post('/store',[AssetLocationController::class, 'store'])->name('lokasi.store');
    Route::get('/{id}/edit',[AssetLocationController::class, 'edit'])->name('lokasi.edit');
    Route::post('/{id}/update',[AssetLocationController::class, 'update'])->name('lokasi.update');
    Route::get('/destroy/{id}',[AssetLocationController::class, 'destroy'])->name('lokasi.destroy');

});

//Aset

Route::prefix('aset')->group(function () {
    Route::get('/',[AssetController::class, 'index'])->name('aset.index');
    Route::get('/create',[AssetController::class, 'create'])->name('aset.create');
    Route::post('/store',[AssetController::class, 'store'])->name('aset.store');
    Route::get('/{id}/edit',[AssetController::class, 'edit'])->name('aset.edit');
    Route::post('/{id}/update',[AssetController::class, 'update'])->name('aset.update');
    Route::get('/destroy/{id}',[AssetController::class, 'destroy'])->name('aset.destroy');

});

//Barang

Route::prefix('barang')->group(function () {
    Route::get('/',[InventoryController::class, 'index'])->name('barang.index');
    Route::get('/create',[InventoryController::class, 'create'])->name('barang.create');
    Route::post('/store',[InventoryController::class, 'store'])->name('barang.store');
    
    Route::get('/{id}/edit',[InventoryController::class, 'edit'])->name('barang.edit');
    Route::post('/{id}/update',[InventoryController::class, 'update'])->name('barang.update');
    Route::get('/destroy/{id}',[InventoryController::class, 'destroy'])->name('barang.destroy');
    Route::get('/search',[InventoryController::class, 'search'])->name('barang.search');
    Route::get('/print',[InventoryController::class, 'print'])->name('barang.print');

    Route::get('/test',[InventoryController::class, 'test'])->name('barang.test');

});


//Bangunan

Route::prefix('bangunan')->group(function () {
    Route::get('/',[BuildingController::class, 'index'])->name('bangunan.index');
    Route::get('/create',[BuildingController::class, 'create'])->name('bangunan.create');
    Route::post('/store',[BuildingController::class, 'store'])->name('bangunan.store');
    Route::get('/{id}/edit',[BuildingController::class, 'edit'])->name('bangunan.edit');
    Route::post('/{id}/update',[BuildingController::class, 'update'])->name('bangunan.update');
    Route::get('/destroy/{id}',[BuildingController::class, 'destroy'])->name('bangunan.destroy');
    Route::get('/search',[BuildingController::class, 'search'])->name('bangunan.search');

    Route::get('/test',[BuildingController::class, 'test'])->name('bangunan.test');

});

//User ADmin
Route::prefix('user')->group(function () {
    Route::get('/',[AdminController::class, 'index'])->name('admin.index');
    Route::get('/create',[AdminController::class, 'create'])->name('admin.create');
    Route::post('/store',[AdminController::class, 'store'])->name('admin.store');
    Route::get('/{id}/edit',[AdminController::class, 'edit'])->name('admin.edit');
    Route::post('/{id}/update',[AdminController::class, 'update'])->name('admin.update');
    Route::get('/destroy/{id}',[AdminController::class, 'destroy'])->name('admin.destroy');

    

});

//User PJ
Route::prefix('pj')->group(function () {
    Route::get('/',[PersonInChargeController::class, 'index'])->name('pj.index');
    Route::get('/create',[PersonInChargeController::class, 'create'])->name('pj.create');
    Route::post('/store',[PersonInChargeController::class, 'store'])->name('pj.store');
    Route::get('/{id}/edit',[PersonInChargeController::class, 'edit'])->name('pj.edit');
    Route::post('/{id}/update',[PersonInChargeController::class, 'update'])->name('pj.update');
    Route::get('/destroy/{id}',[PersonInChargeController::class, 'destroy'])->name('pj.destroy');

});


//User PJ
Route::prefix('mahasiswa')->group(function () {
    Route::get('/',[MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('/create',[MahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::post('/store',[MahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::get('/{id}/edit',[MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::post('/{id}/update',[MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::get('/destroy/{id}',[MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

});

//profile
Route::prefix('profile')->group(function () {
    Route::get('/',[ProfileController::class, 'index'])->name('profile.index');
    Route::get('/edit',[ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/update',[ProfileController::class, 'update'])->name('profile.update');
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

//Peminjaman

Route::prefix('peminjaman')->group(function () {
    Route::get('/',[PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/create',[PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/store',[PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/{id}/edit',[PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::post('/{id}/update',[PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::get('/destroy/{id}',[PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

});

});


//tab
// Route::get('/admin',function(){
//     return view('user');
// });

// Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

// Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

// Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');
