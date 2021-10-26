<?php

use App\Http\Controllers\api\branchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\userController;
use App\Http\Controllers\api\productController;
use App\Http\Controllers\api\roleController;

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

Route::post('/register', [userController::class, 'register']);
Route::post('/login', [userController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('product', productController::class);
    Route::apiResource('role', roleController::class);
    Route::apiResource('branch', branchController::class);
});