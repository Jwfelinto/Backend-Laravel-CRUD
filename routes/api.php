<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InstallationTypesController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

/**
 *
 */
Route::prefix('/clientes')->name('client.')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('index');
    Route::get('/{client}', [ClientController::class, 'show'])->name('show');
    Route::post('/', [ClientController::class, 'store'])->name('store');
    Route::put('/{client}', [ClientController::class, 'update'])->name('update');
    Route::delete('/{client}', [ClientController::class, 'destroy'])->name('destroy');
});

/**
 * Installation Types Routes
 */
Route::prefix('/instalação')->name('installation.')->group(function () {
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
    Route::get('/{project}/equipamentos', [ProjectController::class, 'projectTools'])->name('projectTools');
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
    Route::post('/', [ProjectController::class, 'store'])->name('store');
    Route::put('/{project}', [ProjectController::class, 'update'])->name('update');
    Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');
});

/**
 * Tool Routes
 */
Route::prefix('/equipamentos')->name('tools.')->group(function () {
    Route::get('/', [ToolController::class, 'index'])->name('index');
});
