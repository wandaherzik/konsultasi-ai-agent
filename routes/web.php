<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Dokter\DashboardController as DokterDashboard;
use App\Http\Controllers\Kapus\DashboardController as KapusDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Dokter\JadwalController as JadwalDokter;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\JadwalDokterController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DataPasienController;
use App\Http\Controllers\PasienDashboardController;
use App\Http\Controllers\DokterDashboardController;
use App\Http\Controllers\Pasien\KonsultasiAIController;
use App\Http\Controllers\Pasien\AntrianController;
use App\Http\Controllers\Dokter\AntreanController;
use App\Http\Controllers\Pasien\PasienRekamMedisController;
use App\Http\Controllers\Kapus\LaporanController;
use App\Http\Controllers\Pasien\ProfilController;
use App\Http\Controllers\Dokter\RekamMedisController;


Route::get('/', function () {
    return view('welcome');
});

Route::controller(LoginController::class)->group(function () {

    Route::get('/login', 'index')->name('login');

    Route::post('/login', 'authenticate')->name('login.authenticate');

});

Route::post('/logout', LogoutController::class)
    ->middleware('auth')
    ->name('logout');

    //role admin

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

Route::get(
    '/dashboard',
    [AdminDashboard::class, 'index']
)->name('dashboard');

        Route::resource('users', UserController::class);
        Route::resource('poli', PoliController::class);
        Route::resource('dokter', DokterController::class);
        Route::resource('jadwal-dokter',JadwalDokterController::class);
        Route::resource('pasien',PasienController::class);
          
    });

//role dokter
Route::middleware(['auth', 'role:dokter'])
    ->prefix('dokter')
    ->name('dokter.')
    ->group(function () {

        Route::get(
    '/dashboard',
    [DokterDashboard::class, 'index']
)->name('dashboard');


Route::get(
    '/antrian',
    [AntreanController::class, 'index']
)->name('antrian.index');


Route::post(
    '/antrian/{id}/panggil',
    [AntreanController::class, 'panggil']
)->name('antrian.panggil');


/*
|--------------------------------------------------------------------------
| Pilih konsultasi AI
|--------------------------------------------------------------------------
*/

Route::get(
    '/antrian/{id}/rekam-medis',
    [RekamMedisController::class, 'pilihKonsultasi']
)->name('rekam-medis.pilih-konsultasi');


/*
|--------------------------------------------------------------------------
| Form rekam medis berdasarkan konsultasi AI
|--------------------------------------------------------------------------
*/

Route::get(
    '/antrian/{id}/rekam-medis/{idKonsultasi}',
    [RekamMedisController::class, 'create']
)->name('rekam-medis.create');


/*
|--------------------------------------------------------------------------
| Simpan rekam medis
|--------------------------------------------------------------------------
*/

Route::post(
    '/antrian/{id}/rekam-medis/{idKonsultasi}',
    [RekamMedisController::class, 'store']
)->name('rekam-medis.store');


/*
|--------------------------------------------------------------------------
| Selesaikan antrean
|--------------------------------------------------------------------------
*/

Route::post(
    '/antrian/{id}/selesai',
    [AntreanController::class, 'selesai']
)->name('antrian.selesai');


/*
|--------------------------------------------------------------------------
| Rekam medis
|--------------------------------------------------------------------------
*/

Route::get(
    '/rekam-medis',
    [RekamMedisController::class, 'index']
)->name('rekam-medis.index');


Route::get(
    '/rekam-medis/{id}',
    [RekamMedisController::class, 'show']
)->name('rekam-medis.show');


/*
|--------------------------------------------------------------------------
| Jadwal dokter
|--------------------------------------------------------------------------
*/

Route::get(
    '/jadwal',
    [JadwalDokter::class, 'index']
)->name('jadwal.index');

    });

//role pasien
Route::middleware(['auth','role:pasien'])
    ->prefix('pasien')
    ->name('pasien.')
    ->group(function () {

    Route::get(
        '/pasien/dashboard',
        [PasienDashboardController::class, 'index']
    )->name('pasien.dashboard');

        Route::get(
            '/jadwal-dokter',
            [JadwalDokterController::class, 'pasienIndex']
        )->name('jadwal.index');

            Route::get(
        '/profil',
        [ProfilController::class, 'index']
    )->name('profil.index');


    Route::get(
        '/profil/edit',
        [ProfilController::class, 'edit']
    )->name('profil.edit');


    Route::put(
        '/profil',
        [ProfilController::class, 'update']
    )->name('profil.update');

        Route::get(
            '/jadwal-dokter/{id}/daftar',
            [JadwalDokterController::class, 'daftar']
        )->name('jadwal.daftar');

                Route::get(
            '/antrian',
            [AntrianController::class, 'index']
        )->name('antrian.index');

        Route::post(
            '/antrian',
            [AntrianController::class, 'store']
        )->name('antrian.store');

        Route::get(
        '/pasien/konsultasi',
        [KonsultasiAIController::class, 'index']
    )->name('pasien.konsultasi.index');

    Route::get(
        '/pasien/konsultasi/mulai',
        [KonsultasiAIController::class, 'create']
    )->name('pasien.konsultasi.create');

        Route::post(
        '/pasien/konsultasi',
        [KonsultasiAIController::class, 'store']
    )->name('pasien.konsultasi.store');

Route::get(
    '/konsultasi/{id}',
    [KonsultasiAIController::class, 'show']
)->name('pasien.konsultasi.show');

    Route::post(
        '/pasien/konsultasi/{id_konsultasi_ai}/pesan',
        [KonsultasiAIController::class, 'sendMessage']
    )->name('pasien.konsultasi.send');

Route::post(
    '/pasien/pasien/konsultasi/{id}/selesai',
    [KonsultasiAIController::class, 'finish']
)->name('pasien.konsultasi.finish');
Route::get(
    '/pasien/antrian/create',
    [AntrianController::class, 'create']
)->name(
    'pasien.antrian.create'
);

Route::get(
    '/rekam-medis',
    [
        PasienRekamMedisController::class,
        'index'
    ]
)->name('rekam-medis.index');


Route::get(
    '/rekam-medis/{id}',
    [
PasienRekamMedisController::class,
        'show'
    ]
)->name('rekam-medis.show');
    });

//role Kapus
Route::middleware(['auth','role:kapus'])
    ->prefix('kapus')
    ->name('kapus.')
    ->group(function () {

        Route::get(
            '/dashboard',
            [KapusDashboard::class,'index']
        )->name('dashboard');

            Route::get(
        '/laporan',
        [LaporanController::class, 'index']
    )->name('laporan.index');

    Route::get(
    '/kapus/laporan/export-pdf',
    [\App\Http\Controllers\Kapus\LaporanController::class, 'exportPdf']
)->name('kapus.laporan.export-pdf');

Route::get(
    '/laporan/export-excel',
    [LaporanController::class, 'exportExcel']
)->name('laporan.export-excel');

    });

    Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [
        LoginController::class,
        'index'
    ])->name('login');

    Route::post('/login', [
        LoginController::class,
        'authenticate'
    ])->name('login.authenticate');

    // Register pasien
Route::get('/register', [RegisterController::class, 'create'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');

    Route::middleware('auth')->group(function () {

    Route::get(
        '/pasien/pendaftaran',
        [PasienController::class, 'create']
    )->name('pasien.create');

    Route::post(
        '/pasien/pendaftaran',
        [PasienController::class, 'store']
    )->name('pasien.store');

    

});
});