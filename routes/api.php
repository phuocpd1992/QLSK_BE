<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\PostController;
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


    // User Admin Controller
    Route::post('createUser',[UserAdminController::class,'createUser']);
    Route::post('readUser',[UserAdminController::class,'readUser']);
    Route::post('/readUserById/{id}',[UserAdminController::class,'readUserById']);
    Route::post('/updateUserByID/{id}',[UserAdminController::class,'updateUserByID']);
    Route::post('/deleteUserById/{id}',[UserAdminController::class,'deleteUserById']);
    Route::post('readCompanyList',[UserAdminController::class,'readCompanyList']);
 
    // Post Controller
    Route::post('createPost',[PostController::class,'createPost']);
    Route::post('readPost',[PostController::class,'readPost']);
    Route::post('/readPostById/{id}',[PostController::class,'readPostById']);
    Route::post('/updatePostById/{id}',[PostController::class,'updatePostById']);
    Route::post('/deletePostById/{id}',[PostController::class,'deletePostById']);


});