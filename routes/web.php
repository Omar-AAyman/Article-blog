<?php

use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TemporaryImageController;
use App\Http\Controllers\HomeController as ControllersHomeController;


Route::prefix('/articles')->controller(ArticleController::class)->as('articles')->group(function () {
    Route::get('/',  'index')->name('.index');
    Route::get('/create',  'create')->name('.create');
    Route::post('/store',  'store')->name('.store');

    Route::prefix('/{id}')->group(function () {
        Route::get('/edit', 'edit')->name('.edit');
        Route::put('/update', 'update')->name('.update');
        Route::delete('/destroy', 'destroy')->name('.delete');
    });
});



Route::post('/upload', [TemporaryImageController::class, 'upload'])->name('upload');
Route::delete('/delete', [TemporaryImageController::class, 'delete'])->name('delete');
