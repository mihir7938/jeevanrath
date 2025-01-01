<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

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

Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [AuthController::class, 'getLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('authenticate');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/cities', [AdminController::class, 'cities'])->name('admin.cities');
    Route::get('/cities/add', [AdminController::class, 'addCity'])->name('admin.cities.add');
    Route::post('/cities/save', [AdminController::class, 'saveCity'])->name('admin.cities.add.save');
    Route::get('/cities/delete/{id}', [AdminController::class, 'deleteCity'])->name('admin.cities.delete');
    Route::get('/cars', [AdminController::class, 'cars'])->name('admin.cars');
    Route::get('/cars/add', [AdminController::class, 'addCar'])->name('admin.cars.add');
    Route::post('/cars/save', [AdminController::class, 'saveCar'])->name('admin.cars.add.save');
    Route::get('/cars/edit/{id}', [AdminController::class, 'editCar'])->name('admin.cars.edit');
    Route::post('/cars/update', [AdminController::class, 'updateCar'])->name('admin.cars.update.save');
    Route::get('/cars/delete/{id}', [AdminController::class, 'deleteCar'])->name('admin.cars.delete');
});

Route::group(['prefix' => 'password'], function () {
    Route::get('/forget', [AuthController::class, 'forgetPassword'])->name('forget_password');
    Route::post('/reset', [AuthController::class, 'resetPassword'])->name('check_password_reset');
    Route::get('/reset/{token}', [AuthController::class, 'getChangePassword'])->name('reset_password_link');
    Route::post('/reset/new/{token}', [AuthController::class, 'postChangePassword'])->name('change_password');
});