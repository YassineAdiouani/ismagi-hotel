<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;

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

Route::group(['prefix' => '', 'as' => 'dashboard.'], function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
});

Route::get('/clients/autocomplete', [ClientController::class, 'autocomplete'])->name('clients.autocomplete');
Route::get('/rooms/autocomplete', [RoomController::class, 'autocomplete'])->name('rooms.autocomplete');

Route::resource('clients', ClientController::class);
Route::resource('rooms', RoomController::class);
Route::resource('reservations', ReservationController::class);
Route::resource('payments', PaymentController::class);



Route::get('/{page}', [AdminController::class, 'index']);
