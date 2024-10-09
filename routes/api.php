<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InstallationTypesController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Sign Up Route
 */
Route::post('/cadastro', [UserController::class, 'register'])->name('register');

/**
 * Login
 */
Route::post('/login', [AuthController::class, 'login'])->name('login');


/**
 * Authenticated routes
 */
Route::middleware(['auth:api'])->group(function () {

    /**
     * Logout
     */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /**
     * Client Routes
     */
    Route::prefix('/clientes')->name('client.')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('index');
        Route::post('/', [ClientController::class, 'store'])->name('store');
        Route::get('/{client}', [ClientController::class, 'show'])->name('show');
        Route::put('/{client}', [ClientController::class, 'update'])->name('update');
        Route::delete('/{client}', [ClientController::class, 'destroy'])->name('destroy');
    });

    /**
     * Installation Types Routes
     */
    Route::prefix('/instalacoes')->name('installation.')->group(function () {
        Route::get('/', [InstallationTypesController::class, 'index'])->name('index');
    });

    /**
     * Location Routes
     */
    Route::prefix('/locais')->name('location.')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('index');
    });

    /**
     * Project Routes
     */
    Route::prefix('/projetos')->name('project.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('update');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');
    });

    /**
     * Tool Routes
     */
    Route::prefix('/equipamentos')->name('tools.')->group(function () {
        Route::get('/', [ToolController::class, 'index'])->name('index');
    });

    /**
     * User Routes
     */
    Route::prefix('/usuarios')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

});
