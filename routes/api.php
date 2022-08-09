<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
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

// Client ID: 1
// Client secret: UMVOmWXinAC1TkmUzmGopPEDZqRYvlOon9HR4wis
// Password grant client created successfully.
// Client ID: 2
// Client secret: 1wFIrxolm4oMOkwrBfSS9vnkYVQn4ARE3ZXzf2H8


// Route::middleware('auth:sanctum')->get('/glut', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post("/login",[AuthController::class,"login"]);


Route::group(["middleware"=>["auth:sanctum"]],function(){
    Route::patch('upload/{id}',[UserController::class,"upload"]);
    Route::get('profile',[UserController::class,"profile"]);
    Route::resource('user',"App\Http\Controllers\Api\UserController");
    Route::delete("/logout",[AuthController::class,"logout"]);
    Route::get("search",[UserController::class,"search"]);
});
