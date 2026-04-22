<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FileController::class, 'index'])->name('files.index');
Route::get('/files/list', [FileController::class, 'list']);
Route::post('/upload', [FileController::class, 'store'])->name('files.store');
Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');
