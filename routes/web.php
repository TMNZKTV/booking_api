<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpaController;
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

// Рабочее решение
//Route::get('/{any}', [SpaController::class, 'index'])->where('any', '^((?!api|nova|nova-api).)*$');

// Решение с invoke методом в SpaController
Route::get('/{any}', 'SpaController')->where('any', '^((?!api|nova|nova-api).)*$');

Auth::routes();

