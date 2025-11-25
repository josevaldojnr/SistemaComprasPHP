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
});
