<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', function () {
    return view('index');
});

Route::resource('clients', ClientController::class);
Route::resource('rooms', RoomController::class);

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/stats', 'stats')->name('stats');
        Route::get('/profile', 'profile')->name('profile');
    });
});

Route::get('/{page}', [AdminController::class, 'index']);
