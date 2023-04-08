<?php

use App\Http\Controllers\DataController;
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

Route::get('/', [DataController::class,'start'])->name('start');
Route::get('/update', [DataController::class,'updateVocabulary'])->name('update');
Route::get('/getWords', [DataController::class,'getWords'])->name('getWords');
Route::get('/getData', [DataController::class,'getData'])->name('getData');
Route::get('/all', [DataController::class,'getAll'])->name('all');
Route::get('/{id}', [DataController::class,'start'])->name('start');
Route::get('/update/{method}/{id}', [DataController::class,'update'])->name('update');



