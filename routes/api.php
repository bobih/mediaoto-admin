<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ProspekController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('city',[CityController::class, 'getCity']);
Route::post('login', [LoginController::class, 'login']);

Route::group(['middleware' => [\App\Http\Middleware\JwtMiddleware::class]], function() {

    Route::post("changepass", [UserController::class, 'changePassword']);
    //$routes->post("users", "User::index", ['filter' => 'authFilter']);
    //$routes->post("users", "User::index");
    Route::post("userinfo",  [UserController::class, 'getUserInfo']);
    Route::post("updateimage",  [UserController::class, 'updateImage'] );
    Route::post("updateinfo",  [UserController::class, 'updateUserInfo']);

    //Prospek
    Route::post("summary",  [ProspekController::class, 'getSummary']);
   
   
});
