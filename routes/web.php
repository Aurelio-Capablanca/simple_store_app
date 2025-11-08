<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware('web')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/new_dashboard', function () {
        return file_get_contents(resource_path('dashboard.html'));
    });

    Route::get('/login', function () {
        return view('login');
    })->name('login.form');

    Route::get('/dashboard-insecure', function () {
        return view('dashboard');
    })->name('dashboard.form');

    Route::post('/login', [AuthController::class, 'login'])->name('login');
    //For Secured Endpoints
    Route::middleware('auth')->group(function () {

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard.form');

        //Users
        Route::get('/users', [UserController::class, 'index']
        )->name('users.form');

        Route::post('/create-user', [UserController::class,'create_users'])
        ->name('create-user');
        //Users

        //Store
        //Store

        //Retailer
        //Retailer

        //Entry Products
        //Entry Products

        //Sells
        //Sells
    });
});