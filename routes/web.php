<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// User Routes
Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('/', [JournalController::class, 'index'])->name('user-content.index');
    Route::get('user-content/profile', [JournalController::class, 'profile'])->name('user-content.profile');
    Route::get('user-content/create', [JournalController::class, 'create'])->name('user-content.create');
    Route::post('user-content/upload/', [JournalController::class, 'upload'])->name('user-content.upload');
    Route::post('user-content/search/', [JournalController::class, 'search'])->name('user-content.search');
    Route::get('user-content/journal/{id}', [JournalController::class, 'journal'])->name('user-content.journal');
    Route::delete('user-content/journal/{id}', [JournalController::class, 'destroy'])->name('user-content.delete');
    Route::get('user-content/download-journal/{id}', [JournalController::class, 'download'])->name('download-journal');

});

// Admin routes
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin-content.index');
    Route::get('admin-content/profile/{user_id}', [AdminController::class, 'profile'])->name('admin-content.profile');
    Route::post('admin-content/search/', [AdminController::class, 'search'])->name('admin-content.search');
    Route::get('admin-content/journal/{id}', [AdminController::class, 'journal'])->name('admin-content.journal');
    Route::delete('admin-content/journal/{id}', [AdminController::class, 'destroy'])->name('admin-content.delete');
});

require __DIR__ . '/auth.php';
