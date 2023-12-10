<?php

use App\Http\Controllers\AppController;
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

Route::post('ads', [AppController::class, 'getAds']);

Route::group(['middleware' => [\App\Http\Middleware\JwtMiddleware::class]], function() {


});


Route::post("updateuser", [LoginController::class, 'updateUser']);
Route::post("refreshtoken", [LoginController::class, 'refreshToken']);


Route::post("ads", [AppController::class, 'getAds']);


Route::post("changepass", [UserController::class, 'changePassword']);
//$routes->post("users", "User::index", ['filter' => 'authFilter']);
//$routes->post("users", "User::index");
Route::post("userinfo",  [UserController::class, 'getUserInfo']);
Route::post("updateimage",  [UserController::class, 'updateImage'] );
Route::post("updateinfo",  [UserController::class, 'updateUserInfo']);

//Prospek
Route::post("summary",  [ProspekController::class, 'getSummary']);
Route::post("list",  [ProspekController::class, 'getList']);
Route::post("setfavorite", [ProspekController::class,'setFavorite']);
Route::post("favorite", [ProspekController::class,'getFavorite']);
Route::post("detail", [ProspekController::class,'getDetail']);
Route::post("leadbyid", [ProspekController::class,'getLeadById']);
Route::post("detail", [ProspekController::class,'getDetail']);
Route::post("setnote", [ProspekController::class,'setNote']);
Route::post("phonelog", [ProspekController::class,'phoneLog']);
Route::post("walog", [ProspekController::class,'waLog']);
Route::post("setlost", [ProspekController::class,'setLost']);
Route::post("reminder", [ProspekController::class,'setReminder']);
Route::post("search", [ProspekController::class,'searchLeads']);




