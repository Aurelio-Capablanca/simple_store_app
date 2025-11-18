<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\RetailerController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SalesController;

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

        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

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
        )->name(name: 'users.form');

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
        Route::get('/edit-store/{id}', [StoreController::class, 'edit_modal'])->name('edit-store.modal');

        Route::post('/create-store', [StoreController::class, 'create_stores'])->name('create-store');
        Route::put('/update-store/{id}', [StoreController::class, 'update_store'])->name('update-store');
        Route::delete('/delete-store/{id}', [StoreController::class, 'delete_store'])->name('delete-store');
        //Store


        //Category
        Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
        Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
        Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
        //Category


        //Location
        Route::get('/location', [LocationController::class, 'index'])->name('location.index');
        Route::post('/location', [locationController::class, 'store'])->name('location.store');
        Route::put('/location/{id}', [locationController::class, 'update'])->name('location.update');
        Route::delete('/location/{id}', [locationController::class, 'destroy'])->name('location.destroy');
        //Location

        //Entry Products
        Route::get('/products', [ProductController::class, 'index'])->name('product.form');

        Route::post('/load-product', [ProductController::class, 'load_products'])->name('load-product');
        Route::post('/update-product', [ProductController::class, 'update_products'])->name('update-product');
        Route::get('/product-get/{id}', [ProductController::class, 'edit_modal'])->name('product-get-one');
        Route::delete('/delete-product/{id}', [ProductController::class, 'delete_products'])->name('delete-product');
        //Entry Products

        //Sells
        Route::get('/sales', [SalesController::class, 'index'])->name('sales.form');

        Route::get('/get-product-price/{id}', [SalesController::class, 'call_single_product'])->name('get-product-price');
        Route::delete('/disable-sell/{id}', [SalesController::class, 'disable_sell'])->name('disable-sell');
        Route::post('/do-sales', [SalesController::class, 'do_sell'])->name('do-sales');
        //Sells
    });
});