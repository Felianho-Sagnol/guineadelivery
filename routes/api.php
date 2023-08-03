<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestaurantController;

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

Route::get(
    '/test',[AuthController::class, 'test']
);

//---------------users-------------------------------
Route::post(
    '/user-login',[AuthController::class, 'login']
);


//---------------Restaurants-------------------------------
Route::post(
    '/restaurant-add',[RestaurantController::class, 'add']
);
Route::get(
    '/restaurant-list',[RestaurantController::class, 'restaurants']
);