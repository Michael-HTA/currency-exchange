<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('chart',[ChartController::class,'index'])->name('chart');
Route::post('test',[ExchangeController::class,'index']);
Route::get('test',function(){
    return view('test');
});

require __DIR__.'/auth.php';
