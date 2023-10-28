<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\NilaiBobotAlternatifController;

Route::middleware(['auth', 'role:admin'])->group(function(){

Route::group(['prefix'=> 'Alternatif', 'as'=> 'Alternatif.'],function(){
    Route::controller(AlternatifController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('show', 'show')->name('show');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('destroy', 'destroy')->name('destroy');
    });
});


Route::group(['prefix'=> 'BobotAlternatif', 'as'=> 'BobotAlternatif.'],function(){
    Route::controller(NilaiBobotAlternatifController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('show', 'show')->name('show');
        Route::get('edit', 'edit')->name('edit');
        Route::put('update', 'update')->name('update');
        Route::delete('destroy/{id}', 'destroy')->name('destroy');
        Route::get('GetNilaiBobot1', 'getNilaiBobotAlternatif')->name('getNilaiBobotAlternatif');
        Route::get('GetNilaiBobot2', 'getNilaiBobotAlternatif2')->name('getNilaiBobotAlternatif2');
        Route::get('matrix', 'GetMatrixAlternatif')->name('GetMatrixAlternatif');
        Route::get('matrix/{kode}', 'matrixAlternatif')->name('matrixAlternatif');
        Route::get('BobotPrioritas/{kode}', 'BobotPrioritasAHP')->name('BobotPrioritasAHP');
        Route::get('GetPrioritas/{kode}', 'GetPrioritas')->name('GetPrioritas');
        Route::get('konsistensiAlternatif', 'ConsistencyMeasure')->name('ConsistencyMeasure');
        Route::get('RatioKonsistensi', 'RatioKonsistensi')->name('RatioKonsistensi');
    });
});

});
