<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::middleware(['auth'])->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/work/create', [App\Http\Controllers\HomeController::class, 'create'])->name('work.create');
    Route::get('/work/{work}/toggle', [App\Http\Controllers\HomeController::class, 'toggle'])->name('work.toggle');
    Route::get('/work/{work}/delete', [App\Http\Controllers\HomeController::class, 'delete'])->name('work.delete');
    Route::get('/work/{work}/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('work.edit');
    Route::post('/work/{work}/update', [App\Http\Controllers\HomeController::class, 'update'])->name('work.update');
});

