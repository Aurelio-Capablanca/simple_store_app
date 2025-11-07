<?php

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

        Route::get('/users', function () {
            return view('users');
        })->name('users.form');


    });


});