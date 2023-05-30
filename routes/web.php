<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/update', [DataController::class,'updateVocabulary'])->name('update');
    Route::get('/getWords', [DataController::class,'getWords'])->name('getWords');
    Route::get('/getData', [DataController::class,'getData'])->name('getData');
    Route::get('/all', [DataController::class,'getAll'])->name('all');
    Route::get('/word/{id}', [DataController::class,'getWord'])->name('getWord');
    //Route::get('/{id}', [DataController::class,'start'])->name('start');
    Route::get('/update/{method}/{id}', [DataController::class,'update'])->name('update');
});

require __DIR__.'/auth.php';





