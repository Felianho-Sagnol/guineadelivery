<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderTypeController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\PaymentModeController;

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
    '/restaurants/add',[RestaurantController::class, 'add']
);
Route::get(
    '/restaurants',[RestaurantController::class, 'restaurants']
);
Route::get(
    '/restaurants/{id}',[RestaurantController::class, 'restaurant']
);
Route::get(
    '/restaurants/delete/{id}',[RestaurantController::class, 'delete']
);


//---------------Categories-------------------------------
Route::post(
    '/categories/add',[CategoryController::class, 'add']
);
Route::get(
    '/categories',[CategoryController::class, 'categories']
);
Route::get(
    '/categories/delete/{categoryId}/{restaurantId}',[CategoryController::class, 'delete']
);


//---------------dishes-------------------------------
Route::post(
    '/dishes/add',[DishController::class, 'add']
);
Route::get(
    '/dishes',[DishController::class, 'dishes']
);
Route::get(
    '/categories/delete/{dishId}/{restaurantId}',[DishController::class, 'delete']
);


//---------------order types-------------------------------
Route::post(
    '/orderTypes/add',[OrderTypeController::class, 'add']
);
Route::get(
    '/orderTypes',[OrderTypeController::class, 'orderTypes']
);
Route::get(
    '/orderTypes/delete/{orderTypeId}/{restaurantId}',[OrderTypeController::class, 'delete']
);


//---------------payment modes-------------------------------
Route::post(
    '/paymentModes/add',[PaymentModeController::class, 'add']
);
Route::get(
    '/paymentModes',[PaymentModeController::class, 'paymentModes']
);
Route::get(
    '/paymentModes/delete/{paymentModeId}/{restaurantId}',[PaymentModeController::class, 'delete']
);
