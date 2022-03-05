<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Удалил путь к контроллерам, т.к. в RouteServiceProdiver указан полный путь на 29 строке



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Защитил все роуты миддлвером от Laravel Sanctum
// 2.03.2022 - Роуты не работают, т.к. unauthenticated - видимо не срабатывает проверка от Sanctum
Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::apiResources([
        'tables' => TableController::class,
        'reservations' => ReservationController::class,
        'completed_reservations' => CompletedReservationController::class,
        'failed_reservations' => FailedReservationController::class,
        'logs'=> LogController::class,
        'waiting'=> WaitingUserController::class,
        // 'user' => UserController::class
    ]);
});
