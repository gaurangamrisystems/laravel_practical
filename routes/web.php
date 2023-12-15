<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\CustomerManagementController;
use App\Http\Controllers\TicketManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});
Route::controller(ProductManagementController::class)->group(function() {
    Route::get('/product/list', 'index')->name('productlist');
    Route::get('/product/edit/{id}', 'edit');
    Route::post('/product/update', 'update')->name('productUpdate');
    Route::get('/product/create', 'create')->name('productCreate');
    Route::post('/product/store', 'store')->name('productStore');
});
Route::controller(CustomerManagementController::class)->group(function() {
    Route::get('/customer/list', 'index')->name('customerlist');
    Route::get('/customer/edit/{id}', 'edit');
    Route::post('/customer/update', 'update')->name('customerUpdate');
    Route::get('/customer/create', 'create')->name('customerCreate');
    Route::post('/customer/store', 'store')->name('customerStore');
});
Route::controller(TicketManagementController::class)->group(function() {
    Route::get('/ticket/list', 'index')->name('ticketlist');
    Route::get('/ticket/edit/{id}', 'edit');
    Route::post('/ticket/update', 'update')->name('ticketUpdate');
    Route::get('/ticket/create', 'create')->name('ticketCreate');
    Route::post('/ticket/store', 'store')->name('ticketStore');
});