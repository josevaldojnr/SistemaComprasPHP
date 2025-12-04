<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('login');
})->name('login.form');


Route::get('/register', function () {
    return view('registro');
})->name('register.form');

Route::middleware('auth')->get('/dashboard', function() {
    return view('dashboard');
})->name('dashboard');

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');


Route::post('/register', [UserController::class, 'register'])->name('register');


Route::middleware('auth')->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    
    Route::get('/users/edit/{id}', [UserController::class, 'editUser'])->name('users.edit');
    
    Route::get('/users/delete', [UserController::class, 'deleteUser'])->name('users.delete');
    
    Route::post('/users/update', [UserController::class, 'updateUser'])->name('users.update');
    

    Route::get('/api/users', [UserController::class, 'getAllUsers'])->name('api.users');

    // Products
    Route::resource('products', App\Http\Controllers\ProdutoController::class)->middleware('auth');

    // Sectors
    Route::resource('sectors', App\Http\Controllers\SectorController::class)->except(['show'])->middleware('auth');

    // Categories
    Route::resource('categories', App\Http\Controllers\CategoryController::class)->except(['show'])->middleware('auth');

   // Requisitions
    Route::resource('requisitions', App\Http\Controllers\RequisitionController::class)->only(['index','create'])->middleware('auth');

    Route::post('/requisitions', [App\Http\Controllers\RequisitionController::class, 'store'])
        ->name('requisitions.store')
        ->middleware('auth');

    Route::patch('/requisitions/{id}/update-status', [App\Http\Controllers\RequisitionController::class, 'updateStatus'])->name('requisitions.updateStatus')->middleware('auth');
});