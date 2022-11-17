<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionsController;

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
    Route::apiResource('roles',RolesController::class)->except(['show','update']);
    Route::put('roles',[RolesController::class,'update'])->name('roles.update');
    Route::get('user-permissions', [RolesController::class, 'userPermissions'])->name('user-permissions.index');
    Route::put('user-permissions', [UserPermissionController::class, 'updateUserPermissions'])->name('user-permissions.update');
    Route::apiResource('permissions',PermissionsController::class)->except(['show','updated']);
    Route::put('permissions',[PermissionsController::class,'update'])->name('permissions.update');

    // Settings routes
    Route::get('settings/general',[SettingsController::class,'index'])->name('settings.general');
    Route::post('settings/general',[SettingsController::class,'updateGeneralSettings']);
    
});

// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

