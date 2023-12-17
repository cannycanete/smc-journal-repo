<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JournalController;

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

Route::middleware('auth')->group(function () {
    Route::get('/', [JournalController::class, 'index'])->name('user-content.index');
    Route::get('user-content/profile', [JournalController::class, 'profile'])->name('user-content.profile');
    Route::get('user-content/create', [JournalController::class, 'create'])->name('user-content.create');
    Route::post('user-content/upload/', [JournalController::class, 'upload'])->name('user-content.upload');
    Route::post('user-content/search/', [JournalController::class, 'search'])->name('user-content.search');
    Route::get('user-content/journal/{id}', [JournalController::class, 'journal'])->name('user-content.journal');
});

require __DIR__ . '/auth.php';
