<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScanController;

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

// Route to display the scan form (GET)
Route::get('/scan', [ScanController::class, 'showForm'])->name('scan.form');

// Route to handle the scan submission (POST)
Route::post('/scan', [ScanController::class, 'scan'])->name('scan.submit');
