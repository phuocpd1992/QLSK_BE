<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;
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


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    // AuthController
    Route::post('login',[AuthController::class,'login']);
    Route::post('me', [AuthController::class,'me']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);


    // DataController
    Route::post('create', [DataController::class,'create']);
    Route::post('read', [DataController::class,'read']);
    Route::put('/update/{id}', [DataController::class, 'update']);
    Route::delete('/delete/{id}', [DataController::class, 'delete']);


    // User Controller
 
    Route::post('createUser', \App\Http\Controllers\UserAdminController::class . '@createUser');
    Route::post('readUser', \App\Http\Controllers\UserAdminController::class . '@readUser');
    Route::post('/readUserById/{id}', \App\Http\Controllers\UserAdminController::class . '@readUserById');
    Route::put('/updateUserByID/{id}', \App\Http\Controllers\UserAdminController::class . '@updateUserByID');
    Route::delete('/deleteUserById/{id}', \App\Http\Controllers\UserAdminController::class . '@deleteUserById');
 

 
 
});