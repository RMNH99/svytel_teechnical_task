<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

Route::get('/', function () {
    return view('main');
});

Route::post('/data/export', [DataController::class, 'export'])->name('export');
Route::post('/data/import', [DataController::class, 'import'])->name('import');

Route::get('/export/download', [DataController::class, 'export_download']);