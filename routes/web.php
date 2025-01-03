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
Route::get('/getCities', [PageController::class, 'getCitiesByState'])->name('get_cities');
Route::get('/getVehicles', [PageController::class, 'getVehiclesByType'])->name('get_vehicles');

Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [AuthController::class, 'getLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('authenticate');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

Route::group(['prefix' => 'password'], function () {
    Route::get('/forget', [AuthController::class, 'forgetPassword'])->name('forget_password');
    Route::post('/reset', [AuthController::class, 'resetPassword'])->name('check_password_reset');
    Route::get('/reset/{token}', [AuthController::class, 'getChangePassword'])->name('reset_password_link');
    Route::post('/reset/new/{token}', [AuthController::class, 'postChangePassword'])->name('change_password');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/cities', [AdminController::class, 'cities'])->name('admin.cities');
    Route::get('/cities/add', [AdminController::class, 'addCity'])->name('admin.cities.add');
    Route::post('/cities/save', [AdminController::class, 'saveCity'])->name('admin.cities.add.save');
    Route::get('/cities/edit/{id}', [AdminController::class, 'editCity'])->name('admin.cities.edit');
    Route::post('/cities/update', [AdminController::class, 'updateCity'])->name('admin.cities.update.save');
    Route::get('/cities/delete/{id}', [AdminController::class, 'deleteCity'])->name('admin.cities.delete');
    Route::get('/types', [AdminController::class, 'types'])->name('admin.types');
    Route::get('/types/add', [AdminController::class, 'addType'])->name('admin.types.add');
    Route::post('/types/save', [AdminController::class, 'saveType'])->name('admin.types.add.save');
    Route::get('/types/edit/{id}', [AdminController::class, 'editType'])->name('admin.types.edit');
    Route::post('/types/update', [AdminController::class, 'updateType'])->name('admin.types.update.save');
    Route::get('/types/delete/{id}', [AdminController::class, 'deleteType'])->name('admin.types.delete');
    Route::get('/vehicles', [AdminController::class, 'vehicles'])->name('admin.vehicles');
    Route::get('/vehicles/add', [AdminController::class, 'addVehicle'])->name('admin.vehicles.add');
    Route::post('/vehicles/save', [AdminController::class, 'saveVehicle'])->name('admin.vehicles.add.save');
    Route::get('/vehicles/edit/{id}', [AdminController::class, 'editVehicle'])->name('admin.vehicles.edit');
    Route::post('/vehicles/update', [AdminController::class, 'updateVehicle'])->name('admin.vehicles.update.save');
    Route::get('/vehicles/delete/{id}', [AdminController::class, 'deleteVehicle'])->name('admin.vehicles.delete');
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/categories/add', [AdminController::class, 'addCategory'])->name('admin.categories.add');
    Route::post('/categories/save', [AdminController::class, 'saveCategory'])->name('admin.categories.add.save');
    Route::get('/categories/edit/{id}', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::post('/categories/update', [AdminController::class, 'updateCategory'])->name('admin.categories.update.save');
    Route::get('/categories/delete/{id}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');
    Route::get('/all-vehicles', [AdminController::class, 'cars'])->name('admin.cars');
    Route::get('/all-vehicles/add', [AdminController::class, 'addCar'])->name('admin.cars.add');
    Route::post('/all-vehicles/save', [AdminController::class, 'saveCar'])->name('admin.cars.add.save');
    Route::get('/all-vehicles/edit/{id}', [AdminController::class, 'editCar'])->name('admin.cars.edit');
    Route::post('/all-vehicles/update', [AdminController::class, 'updateCar'])->name('admin.cars.update.save');
    Route::get('/all-vehicles/delete/{id}', [AdminController::class, 'deleteCar'])->name('admin.cars.delete');
});