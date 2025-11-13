<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\RetailerController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware('web')->group(function () {

    Route::get('/', function () {
        return view('welcome');
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

        Route::get(
            '/token-get',
            [ProductController::class, 'call_jwt']
        )->name('token-get');

        //Users
        Route::get(
            '/users',
            [UserController::class, 'index']
        )->name('users.form');

        Route::get('/edit-users/{id}', [UserController::class, 'edit_modal'])
            ->name('edit-user.modal');

        Route::post('/create-user', [UserController::class, 'create_users'])
            ->name('create-user');

        Route::put('/update-user/{id}', [UserController::class, 'update_users'])
            ->name('update-user');

        Route::delete('/delete-user/{id}', [UserController::class, 'delete_users'])
            ->name('delete-user');
        //Users

        //Retailer
        Route::get('/retailers', [RetailerController::class, 'index'])->name('retailer.form');
        Route::get('/edit-retailer/{id}', [RetailerController::class, 'edit_modal'])->name('edit-retailer.modal');

        Route::post('/create-retailer', [RetailerController::class, 'create_retailer'])->name('create-retailer');
        Route::put('/update-retailer/{id}', [RetailerController::class, 'update_retailer'])->name('update-retailer');
        Route::delete('/delete-retailer/{id}', [RetailerController::class, 'delete_retailer'])->name('delete-retailer');
        //Retailer

        //Store
        Route::get('/stores', [StoreController::class, 'index'])->name('stores.form');
        Route::get('/edit-store/{id}', [StoreController::class,'edit_modal'])->name('edit-store.modal');

        Route::post('/create-store', [StoreController::class, 'create_stores'])->name('create-store');
        Route::put('/update-store/{id}', [StoreController::class, 'update_store'])->name('update-store');
        Route::delete('/delete-store/{id}', [StoreController::class, 'delete_store'])->name('delete-store');
        //Store


        //Category
        //Category


        //Location
        //Location

        //Entry Products
        Route::get('/products', [ProductController::class, 'index'])->name('product.form');
        Route::post('/load-product', [ProductController::class, 'load_products'])->name('load-product');

        //Entry Products

        //Sells
        //Sells
    });
});