<?php

use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\NilaiBobotKriteriaController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::group(['prefix' => 'Kriteria', 'as' => 'Kriteria.'], function () {
        Route::controller(KriteriaController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('show', 'show')->name('show');
            Route::get('edit', 'edit')->name('edit');
            Route::put('update', 'update')->name('update');
            Route::delete('destroy', 'destroy')->name('destroy');
        });
    });


    Route::group(['prefix' => 'BobotKriteria', 'as' => 'BobotKriteria.'], function () {
        Route::controller(NilaiBobotKriteriaController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('show', 'show')->name('show');
            Route::get('edit', 'edit')->name('edit');
            Route::put('update', 'update')->name('update');
            Route::delete('destroy', 'destroy')->name('destroy');

            // Generate Matrix Kriteria

            // Perhitungan
            Route::get('GetNilaiBobot1', 'getNilaiBobotKriteria')->name('getNilaiBobotKriteria');
            Route::get('GetNilaiBobot2', 'getNilaiBobotKriteria2')->name('getNilaiBobotKriteria2');
            Route::get('matrix', 'matrixKriteria')->name('matrixKriteria');
            Route::get('BobotPrioritas', 'BobotPrioritasKriteriaAHP')->name('BobotPrioritasKriteriaAHP');
            Route::get('konsistensiKriteria', 'ConsistencyMeasure')->name('ConsistencyMeasure');
            Route::get('RatioKonsistensi', 'RatioKonsistensi')->name('RatioKonsistensi');
        });
    });
});
