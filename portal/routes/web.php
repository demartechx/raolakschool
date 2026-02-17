<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/wallet/history', function () {
    return view('wallet.history', [
        'histories' => Illuminate\Support\Facades\Auth::user()->walletHistory()->latest()->paginate(20)
    ]);
})->middleware(['auth', 'verified'])->name('wallet.history');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/student/enroll', [App\Http\Controllers\EnrollmentController::class, 'create'])->name('student.enroll');
    Route::post('/student/enroll', [App\Http\Controllers\EnrollmentController::class, 'store'])->name('student.enroll.store');
});

require __DIR__ . '/auth.php';

// Catch-all: serve Flutter's index.html for any route not matched above.
// This enables Flutter SPA client-side routing (e.g. refreshing on /home won't 404).
Route::get('/{any}', function () {
    return response()->file(public_path('index.html'));
})->where('any', '.*');
