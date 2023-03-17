<?php

use App\Http\Controllers\Admin\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InspectionToolController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\SerialNumberController;

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

Route::middleware(['auth:web',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('',[DashboardController::class,'index']);

    Route::resource('users',UsersController::class);
    Route::post('user-active', [UsersController::class, 'updateStatus'])->name('user.status.update');
    Route::apiResource('roles',RolesController::class)->except(['show','update']);
    Route::put('roles',[RolesController::class,'update'])->name('roles.update');
    Route::get('user-permissions', [RolesController::class, 'userPermissions'])->name('user-permissions.index');
    Route::put('user-permissions', [RolesController::class, 'updateUserPermissions'])->name('user-permissions.update');
    Route::apiResource('permissions',PermissionsController::class)->except(['show','updated']);
    Route::put('permissions',[PermissionsController::class,'update'])->name('permissions.update');

    Route::apiResource('serialnumbers',SerialNumberController::class)->except(['show','updated']);
    Route::put('serialnumbers',[SerialNumberController::class,'update'])->name('serialnumbers.update');
    Route::apiResource('inspection-tools',InspectionToolController::class)->except(['show','updated']);
    Route::put('inspection-tools',[InspectionToolController::class,'update'])->name('inspection-tools.update');
    Route::apiResource('customers',CustomerController::class)->except(['show','updated']);
    Route::put('customers',[CustomerController::class,'update'])->name('customers.update');

    // Settings routes
    Route::get('settings/general',[SettingsController::class,'index'])->name('settings.general');
    Route::post('settings/general',[SettingsController::class,'updateGeneralSettings']);
    
    // locale Route
    Route::get('lang/{locale}', [LanguageController::class, 'swap']);
});


