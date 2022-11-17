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
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\PersonInChargeController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginPjController as LogTes;
use App\Http\Controllers\Pj\LoginPjController;
use App\Http\Controllers\Pj\TestController;
use App\Http\Controllers\Pj\ProfilePJController;
use App\Http\Controllers\PJ\InventoryPJController;
use App\Http\Controllers\PJ\InventoryItemPJController;
use App\Http\Controllers\PJ\AssetPJController;
use App\Http\Controllers\PJ\AssetLocationPJController;
use App\Http\Controllers\PJ\BuildingPJController;
use App\Http\Controllers\PJ\RekapPJController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\PJ\ProposalPJController;
use App\Http\Controllers\ReturnsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PJ\HomePJController;
use App\Http\Controllers\DetailpeminjamanController;
use App\Http\Controllers\DistribusiController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengadaanController;

use App\Models\PersonInCharge;
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

//forgot Password Admin
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');

Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');

Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');



// Route::get('/forgotPassword',[App\Http\Controllers\Auth\ForgotPasswordController::class, 'request'])->name('password.request');

Route::group(['middleware' => ['auth']], function () {


    Route::get('/', [DashboardController::class, 'index'])->name('index');


    //Reset Password
    Route::get('/changePassword', [App\Http\Controllers\HomeController::class, 'showChangePasswordGet'])->name('changePasswordGet');
    Route::post('/changePassword', [App\Http\Controllers\HomeController::class, 'changePasswordPost'])->name('changePasswordPost');

    //Jenis
    // Route::prefix('jenis')->group(function () {
    //     Route::get('/', [AssetTypeController::class, 'index'])->name('jenis.index');
    //     Route::get('/create', [AssetTypeController::class, 'create'])->name('jenis.create');
    //     Route::post('/store', [AssetTypeController::class, 'store'])->name('jenis.store');
    //     Route::get('/{id}/edit', [AssetTypeController::class, 'edit'])->name('jenis.edit');
    //     Route::post('/{id}/update', [AssetTypeController::class, 'update'])->name('jenis.update');
    //     Route::get('/destroy/{id}', [AssetTypeController::class, 'destroy'])->name('jenis.destroy');
    // });

    //Lokasi
    Route::prefix('lokasi')->group(function () {
        Route::get('/', [AssetLocationController::class, 'index'])->name('lokasi.index');
        Route::get('/create', [AssetLocationController::class, 'create'])->name('lokasi.create');
        Route::post('/store', [AssetLocationController::class, 'store'])->name('lokasi.store');
        Route::get('/{id}/edit', [AssetLocationController::class, 'edit'])->name('lokasi.edit');
        Route::post('/{id}/update', [AssetLocationController::class, 'update'])->name('lokasi.update');
        Route::get('/destroy/{id}', [AssetLocationController::class, 'destroy'])->name('lokasi.destroy');
    });

    //Aset

    Route::prefix('aset')->group(function () {
        Route::get('/', [AssetController::class, 'index'])->name('aset.index');
        Route::get('/create', [AssetController::class, 'create'])->name('aset.create');
        Route::post('/store', [AssetController::class, 'store'])->name('aset.store');
        Route::get('/{id}/edit', [AssetController::class, 'edit'])->name('aset.edit');
        Route::post('/{id}/update', [AssetController::class, 'update'])->name('aset.update');
        Route::get('/destroy/{id}', [AssetController::class, 'destroy'])->name('aset.destroy');
    });

    //Barang

    Route::prefix('barang')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('barang.index');
        Route::get('/create', [InventoryController::class, 'create'])->name('barang.create');
        Route::post('/store', [InventoryController::class, 'store'])->name('barang.store');

        Route::get('/{id}/edit', [InventoryController::class, 'edit'])->name('barang.edit');
        Route::post('/{id}/update', [InventoryController::class, 'update'])->name('barang.update');
        Route::get('/destroy/{id}', [InventoryController::class, 'destroy'])->name('barang.destroy');
        Route::get('/search', [InventoryController::class, 'search'])->name('barang.search');
        Route::get('/print', [InventoryController::class, 'print'])->name('barang.print');



        Route::get('/test', [InventoryController::class, 'test'])->name('barang.test');
    });

    //newBarang
    Route::prefix('newbarang')->group(function () {

        Route::get('/item', [InventoryItemController::class, 'item'])->name('newbarang.item');
        Route::get('/{id}/list', [InventoryItemController::class, 'list'])->name('newbarang.list');
        Route::get('/{id}/print', [InventoryItemController::class, 'print'])->name('newbarang.print');
    });

    //newBarang
    Route::prefix('stock')->group(function () {
        Route::get('/{id}/detail', [InventoryItemController::class, 'index'])->name('stock.index');
        Route::get('/{id}/stock', [InventoryItemController::class, 'stock'])->name('stock.stock');
        Route::get('/creat', [InventoryItemController::class, 'create'])->name('stock.create');
        Route::post('/store', [InventoryItemController::class, 'store'])->name('stock.store');

        Route::post('/{id}/update', [InventoryItemController::class, 'update'])->name('stock.update');
        Route::get('/destroy/{id}', [InventoryItemController::class, 'destroy'])->name('stock.destroy');
    });


    //Bangunan

    Route::prefix('bangunan')->group(function () {
        Route::get('/', [BuildingController::class, 'index'])->name('bangunan.index');
        Route::get('/create', [BuildingController::class, 'create'])->name('bangunan.create');
        Route::post('/store', [BuildingController::class, 'store'])->name('bangunan.store');
        Route::get('/{id}/edit', [BuildingController::class, 'edit'])->name('bangunan.edit');
        Route::post('/{id}/update', [BuildingController::class, 'update'])->name('bangunan.update');
        Route::get('/destroy/{id}', [BuildingController::class, 'destroy'])->name('bangunan.destroy');
        Route::get('/search', [BuildingController::class, 'search'])->name('bangunan.search');
        Route::get('/print', [BuildingController::class, 'print'])->name('bangunan.print');

        Route::get('/test', [BuildingController::class, 'test'])->name('bangunan.test');
    });

    //User ADmin
    Route::prefix('user')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::post('/{id}/update', [AdminController::class, 'update'])->name('admin.update');
        Route::get('/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    });

    //User PJ
    Route::prefix('pj')->group(function () {
        Route::get('/', [PersonInChargeController::class, 'index'])->name('pj.index');
        Route::get('/create', [PersonInChargeController::class, 'create'])->name('pj.create');
        Route::post('/store', [PersonInChargeController::class, 'store'])->name('pj.store');
        Route::get('/{id}/edit', [PersonInChargeController::class, 'edit'])->name('pj.edit');
        Route::post('/{id}/update', [PersonInChargeController::class, 'update'])->name('pj.update');
        Route::get('/destroy/{id}', [PersonInChargeController::class, 'destroy'])->name('pj.destroy');
    });


    //User PJ
    Route::prefix('mahasiswa')->group(function () {
        Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::get('/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
        Route::post('/store', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
        Route::get('/{id}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
        Route::post('/{id}/update', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
        Route::get('/destroy/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
    });

    //profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
    });

    //Rekap
    Route::prefix('Rekap')->group(function () {
        Route::get('/', [RekapController::class, 'index'])->name('rekap.index');
        Route::get('/print', [RekapController::class, 'print'])->name('rekap.print');
        Route::get('/printbarang', [RekapController::class, 'printbarang'])->name('rekap.printbarang');
        Route::get('/printbangunan', [RekapController::class, 'printbangunan'])->name('rekap.printbangunan');
    });

    Route::prefix('proposal')->group(function () {
        Route::get('/', [ProposalController::class, 'index'])->name('pengusulan.index');
        Route::get('/mt', [ProposalController::class, 'indexmt'])->name('pengusulanmt.index');
        Route::get('/{id}/show', [ProposalController::class, 'show'])->name('pengusulan.show');
        Route::get('/{id}/showmt', [ProposalController::class, 'showmt'])->name('pengusulanmt.show');
        Route::get('/{id}/acc', [ProposalController::class, 'acc'])->name('pengusulan.acc');
        Route::get('/{id}/reject', [ProposalController::class, 'reject'])->name('pengusulan.reject');
        Route::get('/{id}/accmt', [ProposalController::class, 'accmt'])->name('pengusulanmt.acc');
        Route::get('/{id}/rejectmt', [ProposalController::class, 'rejectmt'])->name('pengusulanmt.reject');
        // Route::get('/buildingloan', [LoanController::class, 'indexbangunan'])->name('pj-aset.peminjamanbangunan.index');
    }); 

    Route::prefix('notifikasi')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifikasi.index');
        Route::post('/update', [NotificationController::class, 'update'])->name('notifikasi.update');
    }); 
   
});


Auth::routes();

Route::prefix('pj-aset')->group(function () {
    Route::get('/showlogin', [LogTes::class, 'showLoginForm'])->name('pj-aset.show');
    Route::post('/pjlogin', [LogTes::class, 'login'])->name('pj-aset.login');
    Route::get('/logout', [LogTes::class, 'logout'])->name('pj-aset.logout');


    Route::get('/success', [TestController::class, 'sucessf'])->name('pj-aset.success');

    Route::group(['middleware' => ['auth:pj']], function () {

        Route::get('/', [DashboardController::class, 'indexPj'])->name('indexPj');
        // Route::get('/', function () {
        //     return view('index');
        // })->name('index');

        //profile
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfilePJController::class, 'index'])->name('pj-aset.profile.index');
            Route::get('/edit', [ProfilePJController::class, 'edit'])->name('pj-aset.profile.edit');
            Route::post('/update', [ProfilePJController::class, 'update'])->name('pj-aset.profile.update');
        });

        //Reset Password
        Route::get('/changePassword', [App\Http\Controllers\PJ\HomePJController::class, 'showChangePasswordGet'])->name('pj-aset.changePasswordGet');
        Route::post('/changePassword', [App\Http\Controllers\PJ\HomePJController::class, 'changePasswordPost'])->name('pj-aset.changePasswordPost');
    });


    //LokasiPJ
    Route::prefix('lokasi')->group(function () {
        Route::get('/', [AssetLocationPJController::class, 'index'])->name('pj-aset.lokasi.index');
        Route::get('/create', [AssetLocationPJController::class, 'create'])->name('pj-aset.lokasi.create');
        Route::post('/store', [AssetLocationPJController::class, 'store'])->name('pj-aset.lokasi.store');
        Route::get('/{id}/edit', [AssetLocationPJController::class, 'edit'])->name('pj-aset.lokasi.edit');
        Route::post('/{id}/update', [AssetLocationPJController::class, 'update'])->name('pj-aset.lokasi.update');
        Route::get('/destroy/{id}', [AssetLocationPJController::class, 'destroy'])->name('pj-aset.lokasi.destroy');
    });

    //AsetPJ

    Route::prefix('aset')->group(function () {
        Route::get('/', [AssetPJController::class, 'index'])->name('pj-aset.aset.index');
        Route::get('/create', [AssetPJController::class, 'create'])->name('pj-aset.aset.create');
        Route::post('/store', [AssetPJController::class, 'store'])->name('pj-aset.aset.store');
        Route::get('/{id}/edit', [AssetPJController::class, 'edit'])->name('pj-aset.aset.edit');
        Route::post('/{id}/update', [AssetPJController::class, 'update'])->name('pj-aset.aset.update');
        Route::get('/destroy/{id}', [AssetPJController::class, 'destroy'])->name('pj-aset.aset.destroy');
    });

    //Barang

    Route::prefix('barang')->group(function () {
        Route::get('/', [InventoryPJController::class, 'index'])->name('pj-aset.barang.index');
        Route::get('/create', [InventoryPJController::class, 'create'])->name('pj-aset.barang.create');
        Route::post('/store', [InventoryPJController::class, 'store'])->name('pj-aset.barang.store');
        Route::get('/{id}/edit', [InventoryPJController::class, 'edit'])->name('pj-aset.barang.edit');
        Route::post('/{id}/update', [InventoryPJController::class, 'update'])->name('pj-aset.barang.update');
        Route::get('/destroy/{id}', [InventoryPJController::class, 'destroy'])->name('pj-aset.barang.destroy');
        Route::get('/print', [InventoryPJController::class, 'print'])->name('pj-aset.barang.print');
    });


    //Bangunan

    Route::prefix('bangunan')->group(function () {
        Route::get('/', [BuildingPjController::class, 'index'])->name('pj-aset.bangunan.index');
        Route::get('/create', [BuildingPjController::class, 'create'])->name('pj-aset.bangunan.create');
        Route::post('/store', [BuildingPjController::class, 'store'])->name('pj-aset.bangunan.store');
        Route::get('/{id}/edit', [BuildingPjController::class, 'edit'])->name('pj-aset.bangunan.edit');
        Route::post('/{id}/update', [BuildingPjController::class, 'update'])->name('pj-aset.bangunan.update');
        Route::get('/destroy/{id}', [BuildingPjController::class, 'destroy'])->name('pj-aset.bangunan.destroy');
        Route::get('/search', [BuildingPJController::class, 'search'])->name('pj-aset.bangunan.search');
        Route::get('/print', [BuildingPJController::class, 'print'])->name('pj-aset.bangunan.print');
    });

    //newBarang
    Route::prefix('stock')->group(function () {
        Route::get('/{id}/detail', [InventoryItemPJController::class, 'index'])->name('pj-aset.stock.index');
        Route::get('/{id}/stock', [InventoryItemPJController::class, 'stock'])->name('pj-aset.stock.stock');
        Route::get('/creat', [InventoryItemPJController::class, 'create'])->name('pj-aset.stock.create');
        Route::post('/store', [InventoryItemPJController::class, 'store'])->name('pj-aset.stock.store');

        Route::post('/{id}/update', [InventoryItemPJController::class, 'update'])->name('pj-aset.stock.update');
        Route::get('/destroy/{id}', [InventoryItemPJController::class, 'destroy'])->name('pj-aset.stock.destroy');
    });


    //Rekap
    Route::prefix('rekap')->group(function () {
        Route::get('/', [RekapPJController::class, 'index'])->name('pj-aset.rekap.index');
        Route::get('/print', [RekapPJController::class, 'print'])->name('pj-aset.rekap.print');
        Route::get('/printbarang', [RekapPJController::class, 'printbarang'])->name('pj-aset.rekap.printbarang');
        Route::get('/printbangunan', [RekapPJController::class, 'printbangunan'])->name('pj-aset.rekap.printbangunan');
    });


    //Peminjaman

    Route::prefix('peminjaman')->group(function () {
        Route::get('/', [LoanController::class, 'index'])->name('pj-aset.peminjaman.index');
        Route::get('/{id}/show', [LoanController::class, 'show'])->name('pj-aset.peminjaman.show');
        Route::get('/{id}/showbg', [LoanController::class, 'showbg'])->name('pj-aset.peminjamanbangunan.show');
        Route::get('/{id}/acc', [LoanController::class, 'acc'])->name('pj-aset.peminjaman.acc');
        Route::get('/{id}/reject', [LoanController::class, 'reject'])->name('pj-aset.peminjaman.reject');
        Route::get('/{id}/accbg', [LoanController::class, 'accbg'])->name('pj-aset.peminjamanbg.acc');
        Route::get('/{id}/rejectbg', [LoanController::class, 'rejectbg'])->name('pj-aset.peminjamanbg.reject');

        Route::get('/bgn', [LoanController::class, 'indexbangunan'])->name('pj-aset.peminjamanbangunan.index');
        Route::get('/create', [LoanController::class, 'create'])->name('pj-aset.peminjaman.create');
        Route::post('/store', [LoanController::class, 'store'])->name('pj-aset.peminjaman.store');
        Route::get('/{id}/edit', [LoanController::class, 'edit'])->name('pj-aset.peminjaman.edit');
        Route::post('/{id}/update', [LoanController::class, 'update'])->name('pj-aset.peminjaman.update');
        Route::get('/destroy/{id}', [LoanController::class, 'destroy'])->name('pj-aset.peminjaman.destroy');
    }); 

     //Pngusulan

    
    Route::prefix('pengusulan')->group(function () {
        Route::get('/', [ProposalPJController::class, 'index'])->name('pj-aset.pengusulan.index');
        Route::get('/mt', [ProposalPJController::class, 'indexmt'])->name('pj-aset.pengusulanmt.index');
        Route::get('/{id}/show', [ProposalPJController::class, 'show'])->name('pj-aset.pengusulan.show');
        Route::get('/{id}/showmt', [ProposalPJController::class, 'showmt'])->name('pj-aset.pengusulanmt.show');
        Route::get('/{id}/acc', [ProposalPJController::class, 'acc'])->name('pj-aset.pengusulan.acc');
        Route::get('/{id}/reject', [ProposalPJController::class, 'reject'])->name('pj-aset.pengusulan.reject');
        Route::get('/{id}/accmt', [ProposalPJController::class, 'accmt'])->name('pj-aset.pengusulanmt.acc');
        Route::get('/{id}/rejectmt', [ProposalPJController::class, 'rejectmt'])->name('pj-aset.pengusulanmt.reject');
        // Route::get('/buildingloan', [LoanController::class, 'indexbangunan'])->name('pj-aset.peminjamanbangunan.index');
        Route::get('/create', [ProposalPJController::class, 'create'])->name('pj-aset.pengusulan.create');
        Route::get('/createmt', [ProposalPJController::class, 'createmt'])->name('pj-aset.pengusulanmt.create');
        
        Route::post('/store', [ProposalPJController::class, 'store'])->name('pj-aset.pengusulan.store');
        Route::post('/storemt', [ProposalPJController::class, 'storemt'])->name('pj-aset.pengusulan.storemt');
        Route::get('/{id}/cancel', [ProposalPJController::class, 'cancel'])->name('pj-aset.pengusulan.cancelmt');
        Route::get('/{id}/edit', [ProposalPJController::class, 'edit'])->name('pj-aset.pengusulan.edit');
        Route::get('/{id}/editmt', [ProposalPJController::class, 'editmt'])->name('pj-aset.pengusulan.editmt');
        Route::post('/{id}/update', [ProposalPJController::class, 'update'])->name('pj-aset.pengusulan.update');
        Route::get('/destroy/{id}', [ProposalPJController::class, 'destroy'])->name('pj-aset.pengusulan.destroy');
    });

 

    Route::prefix('pengembalian')->group(function () {
        Route::get('/', [ReturnsController::class, 'index'])->name('pj-aset.returnaset.index');
        Route::get('/bgn', [ReturnsController::class, 'indexBangunan'])->name('pj-aset.returnaset.indexBangunan');
        Route::get('/show/{id}', [ReturnsController::class, 'show'])->name('pj-aset.returnaset.show');
        Route::get('/{id}/back', [ReturnsController::class, 'back'])->name('pj-aset.returnaset.back');
       
    }); 

    Route::prefix('notifikasi')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifikasi.index');
        Route::post('/update', [NotificationController::class, 'update'])->name('notifikasi.update');
    }); 
});
