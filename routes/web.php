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
    return redirect()->route('login');
});

if (config('app.env') === 'production') {
    Auth::routes([
        'register' => false
    ]);
} else {
    Auth::routes();
}
Route::middleware(['auth'])->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::prefix('client')->group(function() {
        Route::get('{client}', [App\Http\Controllers\ClientController::class, 'works'])->name('client');
        Route::post('create', [App\Http\Controllers\ClientController::class, 'create'])->name('client.create');
        Route::get('{client}/edit', [App\Http\Controllers\ClientController::class, 'edit'])->name('client.edit');
        Route::post('{client}/update', [App\Http\Controllers\ClientController::class, 'update'])->name('client.update');
        Route::get('{client}/delete', [App\Http\Controllers\ClientController::class, 'delete'])->name('client.delete');
    });
    Route::prefix('work')->group(function(){
        Route::post('{client}/create', [App\Http\Controllers\WorkController::class, 'create'])->name('work.create');
        Route::get('{work}/toggle', [App\Http\Controllers\WorkController::class, 'toggle'])->name('work.toggle');
        Route::get('{work}/delete', [App\Http\Controllers\WorkController::class, 'delete'])->name('work.delete');
        Route::get('{work}/edit', [App\Http\Controllers\WorkController::class, 'edit'])->name('work.edit');
        Route::post('{work}/update', [App\Http\Controllers\WorkController::class, 'update'])->name('work.update');
    });
});

