<?php

use App\Http\Controllers\BookMarkController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', [ExchangeController::class, 'getData'])->name('home');
Route::get('/chart', [ChartController::class, 'index'])->name('chart');
Route::post('/chart', [ChartController::class, 'getChartData'])->name('chart.data');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/bookmark', [BookMarkController::class, 'store'])->name('bookmark.store');
    Route::get('/bookmark', [BookMarkController::class, 'index'])->name('bookmark.show');
    Route::post('/bookmark/delete', [BookMarkController::class, 'destroy'])->name('bookmark.destroy');
});





// Route::post('test', [ExchangeController::class, 'getData']);
// Route::get('test', function () {
//     return view('test');
// });

require __DIR__ . '/auth.php';
