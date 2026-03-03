<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\DataSPPGController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('login'));

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    // SUPER ADMIN
    Route::middleware(['role:super-admin'])->group(function () {

        Route::get('/superadmin', fn() => view('dashboard.superadmin'))
            ->name('superadmin.dashboard');

        Route::get('/pending-users', [AuthController::class, 'pendingUsers'])
            ->name('pending.users');

        Route::post('/approve/{id}', [AuthController::class, 'approveUser'])
            ->name('approve.user');

    });

    Route::middleware(['auth','role:super-admin'])->group(function() {
        Route::get('/role-permission', [RolePermissionController::class, 'index'])
            ->name('role.permission');

        Route::post('/role-permission/role', [RolePermissionController::class, 'storeRole'])
            ->name('role.store');

        Route::post('/role-permission/permission', [RolePermissionController::class, 'storePermission'])
            ->name('permission.store');

        Route::post('/role-permission/assign', [RolePermissionController::class, 'assignPermission'])
            ->name('permission.assign');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

        Route::get('/role-permission', [AuthController::class,'rolePermission'])->name('role.permission');
        
        Route::post('/approve-user/{id}', [AuthController::class,'approveUser'])->name('approve.user');

        Route::post('/reject-user/{id}', [AuthController::class,'rejectUser'])->name('reject.user');
    });
        

    // ADMIN
    Route::middleware(['role:admin'])->group(function () {

        Route::get('/admin', fn() => view('dashboard.admin'))
            ->name('admin.dashboard');
        
        Route::get('datasppg/create', [DataSPPGController::class, 'create'])->name('datasppg.create');
        Route::post('datasppg', [DataSPPGController::class, 'store'])->name('datasppg.store');
        Route::get('datasppg/{datasppg}/edit', [DataSPPGController::class, 'edit'])->name('datasppg.edit');
        Route::put('datasppg/{datasppg}', [DataSPPGController::class, 'update'])->name('datasppg.update');
        Route::delete('datasppg/{datasppg}', [DataSPPGController::class, 'destroy'])->name('datasppg.destroy');
    });

        Route::middleware(['auth'])->group(function () {
            Route::get('datasppg', [DataSPPGController::class, 'index'])->name('datasppg.index');
        });


    // USER
    Route::middleware(['role:user'])->group(function () {

        Route::get('/user', fn() => view('dashboard.user'))
            ->name('user.dashboard');
    });

    // untuk user biasa
    Route::middleware(['auth','role:user'])->group(function () {
        Route::get('/user', function() {
            return view('dashboard.user'); // dashboard user
        })->name('user.dashboard');

        Route::get('/user', function() {
            return view('dashboard.user');
        })->name('user.dashboard')->middleware(['auth','role:user']);

        Route::middleware(['auth','role:user'])->group(function() {
            Route::get('/user/data', [App\Http\Controllers\UserController::class, 'lihatData'])->name('lihat.data');
        });

        Route::get('/user/data', [App\Http\Controllers\UserController::class, 'lihatData'])
        ->name('lihat.data')
        ->middleware(['auth', 'role:user']);
    });



    // PEMDA
    Route::middleware(['role:pemda'])->group(function () {

        Route::get('/pemda', fn() => view('dashboard.pemda'))
            ->name('pemda.dashboard');
    });

});