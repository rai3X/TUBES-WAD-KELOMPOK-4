<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Auth\RegisterController;

// Home Route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Registration Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Mahasiswa Routes
    Route::middleware(['role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
        
        // Lomba
        Route::get('/lomba', [App\Http\Controllers\Mahasiswa\LombaController::class, 'index'])->name('lomba');
        Route::get('/lomba/daftar/{id}', [App\Http\Controllers\Mahasiswa\PendaftaranLombaController::class, 'show'])->name('lomba.daftar');
        Route::post('/lomba/daftar/{id}', [App\Http\Controllers\Mahasiswa\PendaftaranLombaController::class, 'store'])->name('lomba.daftar.store');
        Route::get('/lomba/daftar/{id}/detail', [App\Http\Controllers\Mahasiswa\PendaftaranLombaController::class, 'detail'])->name('lomba.daftar.detail');
        Route::delete('/lomba/daftar/{id}/cancel', [App\Http\Controllers\Mahasiswa\PendaftaranLombaController::class, 'cancel'])->name('lomba.daftar.cancel');
        Route::put('/lomba/daftar/{id}/withdraw', [App\Http\Controllers\Mahasiswa\PendaftaranLombaController::class, 'withdraw'])->name('lomba.daftar.withdraw');
        Route::delete('/lomba/daftar/{id}/destroy', [App\Http\Controllers\Mahasiswa\PendaftaranLombaController::class, 'destroy'])->name('lomba.daftar.destroy');
        
        // Jadwal Management
        Route::get('/jadwal', [App\Http\Controllers\Mahasiswa\JadwalController::class, 'index'])->name('jadwal.index');
        Route::post('/jadwal', [App\Http\Controllers\Mahasiswa\JadwalController::class, 'store'])->name('jadwal.store');
        Route::put('/jadwal/{id}', [App\Http\Controllers\Mahasiswa\JadwalController::class, 'update'])->name('jadwal.update');
        Route::delete('/jadwal/{id}', [App\Http\Controllers\Mahasiswa\JadwalController::class, 'destroy'])->name('jadwal.destroy');
        Route::delete('/jadwal/{id}/delete', [App\Http\Controllers\Mahasiswa\JadwalController::class, 'delete'])->name('jadwal.delete');
        
        // Document Management
        Route::get('/dokumen', [App\Http\Controllers\Mahasiswa\DokumenController::class, 'index'])->name('dokumen.index');
        Route::post('/dokumen', [App\Http\Controllers\Mahasiswa\DokumenController::class, 'store'])->name('dokumen.store');
        Route::get('/dokumen/{id}/download', [App\Http\Controllers\Mahasiswa\DokumenController::class, 'download'])->name('dokumen.download');
        Route::delete('/dokumen/{id}', [App\Http\Controllers\Mahasiswa\DokumenController::class, 'destroy'])->name('dokumen.destroy');
        
        // Profile
        Route::get('/profile', [App\Http\Controllers\Mahasiswa\ProfileController::class, 'index'])->name('profile');
    });

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Lomba Management Routes
        Route::get('/lomba', [App\Http\Controllers\Admin\LombaController::class, 'index'])->name('lomba.index');
        Route::post('/lomba', [App\Http\Controllers\Admin\LombaController::class, 'store'])->name('lomba.store');
        Route::put('/lomba/{lomba}', [App\Http\Controllers\Admin\LombaController::class, 'update'])->name('lomba.update');
        Route::delete('/lomba/{lomba}', [App\Http\Controllers\Admin\LombaController::class, 'destroy'])->name('lomba.destroy');
        
        // Document Management Routes
        Route::get('/dokumen', [App\Http\Controllers\Admin\DokumenController::class, 'index'])->name('dokumen.index');
        Route::get('/dokumen/{dokumen}', [App\Http\Controllers\Admin\DokumenController::class, 'show'])->name('dokumen.show');
        Route::put('/dokumen/{dokumen}/verify', [App\Http\Controllers\Admin\DokumenController::class, 'verify'])->name('dokumen.verify');
        Route::put('/dokumen/{dokumen}/revision', [App\Http\Controllers\Admin\DokumenController::class, 'revision'])->name('dokumen.revision');
        Route::put('/dokumen/{dokumen}/reject', [App\Http\Controllers\Admin\DokumenController::class, 'reject'])->name('dokumen.reject');
        Route::delete('/dokumen/{dokumen}', [App\Http\Controllers\Admin\DokumenController::class, 'destroy'])->name('dokumen.destroy');

        // Jadwal Coaching Management Routes
        Route::get('/jadwal', [App\Http\Controllers\Admin\JadwalController::class, 'index'])->name('jadwal.index');
        Route::put('/jadwal/{jadwal}/approve', [App\Http\Controllers\Admin\JadwalController::class, 'approve'])->name('jadwal.approve');
        Route::put('/jadwal/{jadwal}/reject', [App\Http\Controllers\Admin\JadwalController::class, 'reject'])->name('jadwal.reject');
        Route::delete('/jadwal/{jadwal}', [App\Http\Controllers\Admin\JadwalController::class, 'destroy'])->name('jadwal.destroy');
    });
});