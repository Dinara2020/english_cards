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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', [DataController::class,'start'])->name('start');
Route::get('/update', [DataController::class,'updateVocabulary'])->name('update');
Route::get('/test/{id}/{direction}', [DataController::class,'start'])->name('start');
Route::get('/test/{id}', [DataController::class,'start'])->name('start');
Route::get('/test/update/{method}/id{id}', [DataController::class,'update'])->name('update');
Route::get('/getWords', [DataController::class,'getWords'])->name('getWords');

