<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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
Route::get('/search-rental', [PageController::class, 'searchRental'])->name('search_rental');
Route::get('/search-rental/getRentalResults', [PageController::class, 'getRentalResults'])->name('get_rental_results');
Route::get('/search-fixed', [PageController::class, 'searchFixed'])->name('search_fixed');
Route::get('/search-fixed/getFixedResults', [PageController::class, 'getFixedResults'])->name('get_fixed_results');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/getCities', [PageController::class, 'getCitiesByState'])->name('get_cities');
Route::get('/getVehicles', [PageController::class, 'getVehiclesByType'])->name('get_vehicles');
Route::post('/send-enquiry', [PageController::class, 'sendEnquiry'])->name('send_enquiry');

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
    Route::get('/fetch-inquiries', [AdminController::class, 'fetchInquiries'])->name('admin.inquiries.fetch');
    Route::get('/inquiries/edit/{id}', [AdminController::class, 'editInquiry'])->name('admin.inquiries.edit');
    Route::post('/inquiries/update', [AdminController::class, 'updateInquiry'])->name('admin.inquiries.update.save');
    Route::get('/inquiries/delete/{id}', [AdminController::class, 'deleteInquiry'])->name('admin.inquiries.delete');
    Route::get('/inquiries/all', [AdminController::class, 'allInquiry'])->name('admin.inquiries.all');
    Route::get('/invoices', [AdminController::class, 'invoices'])->name('admin.invoices');
    Route::get('/invoices/approve/{id}', [AdminController::class, 'approveInvoice'])->name('admin.invoices.approve');
    Route::post('/invoices/update', [AdminController::class, 'updateInvoice'])->name('admin.invoices.approve.update');
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
    Route::get('/drivers', [AdminController::class, 'drivers'])->name('admin.drivers');
    Route::get('/drivers/add', [AdminController::class, 'addDriver'])->name('admin.drivers.add');
    Route::post('/drivers/save', [AdminController::class, 'saveDriver'])->name('admin.drivers.add.save');
    Route::get('/drivers/edit/{id}', [AdminController::class, 'editDriver'])->name('admin.drivers.edit');
    Route::post('/drivers/update', [AdminController::class, 'updateDriver'])->name('admin.drivers.update.save');
    Route::get('/drivers/delete/{id}', [AdminController::class, 'deleteDriver'])->name('admin.drivers.delete');
    Route::get('/companies', [AdminController::class, 'companies'])->name('admin.companies');
    Route::get('/companies/add', [AdminController::class, 'addCompany'])->name('admin.companies.add');
    Route::post('/companies/save', [AdminController::class, 'saveCompany'])->name('admin.companies.add.save');
    Route::get('/companies/edit/{id}', [AdminController::class, 'editCompany'])->name('admin.companies.edit');
    Route::post('/companies/update', [AdminController::class, 'updateCompany'])->name('admin.companies.update.save');
    Route::get('/companies/delete/{id}', [AdminController::class, 'deleteCompany'])->name('admin.companies.delete');
    Route::get('/jrvehicles', [AdminController::class, 'jRVehicles'])->name('admin.jrvehicles');
    Route::get('/jrvehicles/add', [AdminController::class, 'addJRVehicle'])->name('admin.jrvehicles.add');
    Route::post('/jrvehicles/save', [AdminController::class, 'saveJRVehicle'])->name('admin.jrvehicles.add.save');
    Route::get('/jrvehicles/edit/{id}', [AdminController::class, 'editJRVehicle'])->name('admin.jrvehicles.edit');
    Route::post('/jrvehicles/update', [AdminController::class, 'updateJRVehicle'])->name('admin.jrvehicles.update.save');
    Route::get('/jrvehicles/delete/{id}', [AdminController::class, 'deleteJRVehicle'])->name('admin.jrvehicles.delete');
    Route::get('/all-vehicles', [AdminController::class, 'allVehicles'])->name('admin.details');
    Route::post('/fetch-list', [AdminController::class, 'fetchListByCategory'])->name('admin.list.fetch');
    Route::get('/vehicle-details/add', [AdminController::class, 'addVehicleDetails'])->name('admin.details.add');
    Route::post('/vehicle-details/save', [AdminController::class, 'saveVehicleDetails'])->name('admin.details.add.save');
    Route::get('/vehicle-details/edit/{id}', [AdminController::class, 'editVehicleDetails'])->name('admin.details.edit');
    Route::post('/vehicle-details/update', [AdminController::class, 'updateVehicleDetails'])->name('admin.details.update.save');
    Route::get('/vehicle-details/delete/{id}', [AdminController::class, 'deleteVehicleDetails'])->name('admin.details.delete');
    Route::post('/fetch-details', [AdminController::class, 'fetchDetailsByCategory'])->name('admin.details.fetch');
    Route::get('/users', [AdminController::class, 'getUsers'])->name('admin.users');
    Route::get('/users/add', [AdminController::class, 'addUser'])->name('admin.users.add');
    Route::post('/users/save', [AdminController::class, 'saveUser'])->name('admin.users.add.save');
    Route::get('/users/edit/{id}', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/users/update', [AdminController::class, 'updateUser'])->name('admin.users.update.save');
    Route::get('/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/users/change/{id}', [AdminController::class, 'changePassword'])->name('admin.users.change');
    Route::post('/users/change-password', [AdminController::class, 'updateChangePassword'])->name('admin.users.password.change');
    Route::get('/whatsapp', [AdminController::class, 'whatsapp'])->name('admin.whatsapp');
    Route::get('/whatsapp/qrcode', [AdminController::class, 'showQRCode'])->name('admin.whatsapp.qrcode');		
    Route::get('/whatsapp/check', [AdminController::class, 'checkStatus'])->name('admin.whatsapp.check');
});

Route::group(['prefix' => 'users', 'middleware' => 'user'], function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/fetch-details', [UserController::class, 'fetchDetails'])->name('users.details.fetch');
    Route::post('/duty/save', [UserController::class, 'saveDuty'])->name('users.duty.save');
    Route::get('/reports', [UserController::class, 'reports'])->name('users.reports');
});