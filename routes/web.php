<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get("/debug", [\App\Http\Controllers\MyController::class, 'debug'])->name('debug');


Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('clients', \App\Http\Controllers\ClientController::class);
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('records', \App\Http\Controllers\RecordController::class);

    Route::get('/summary', [\App\Http\Controllers\SummaryController::class, 'index'])->name('summary.index');
    Route::get('/summary/cilents', [\App\Http\Controllers\SummaryController::class, 'clients'])->name('summary.clients');
});

Route::get('/get-municipalities/{orpId}', [\App\Http\Controllers\MyController::class, 'getMunicipalities'])->name('municipalities');

require __DIR__.'/auth.php';
