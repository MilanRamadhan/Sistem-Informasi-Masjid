<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasjidController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

// Rute default ke halaman login (untuk user belum login)
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('masjids.index');
    }
    return view('auth.login');
})->name('welcome');

// Rute yang bisa diakses setelah login (baik admin maupun user biasa)
Route::middleware('auth')->group(function () {
    // User dan Admin bisa melihat daftar & jadwal
    Route::get('/masjids', [MasjidController::class, 'index'])->name('masjids.index');
    Route::get('/masjids/{masjid}', [MasjidController::class, 'show'])->name('masjids.show');

    // Rute untuk Profile Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute KHUSUS ADMIN (CRUD Penuh)
    // Middleware 'role:admin' yang Anda buat akan membatasi aksesnya
    Route::middleware('role:admin')->group(function () {
        Route::get('/new-masjid-form', [MasjidController::class, 'create'])->name('masjids.create_form');
        Route::post('/masjids', [MasjidController::class, 'store'])->name('masjids.store');
        Route::get('/masjids/{masjid}/edit', [MasjidController::class, 'edit'])->name('masjids.edit');
        Route::put('/masjids/{masjid}', [MasjidController::class, 'update'])->name('masjids.update');
        Route::delete('/masjids/{masjid}', [MasjidController::class, 'destroy'])->name('masjids.destroy');
    });
});

// Rute autentikasi Laravel Breeze
require __DIR__.'/auth.php';