<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Client\AuthController as ClientAuthController;
use App\Http\Controllers\Api\Client\ProductsController;

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

//API auth routes Client

Route::group(['middleware' => ['ApiHeaderVerify']], function () {

    Route::controller(ClientAuthController::class)->group(function(){
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
    
    Route::middleware('auth:sanctum')->group(function(){
    
        //Customer Auth Actions
        Route::controller(ClientAuthController::class)->group(function(){
            Route::post('user', 'getUser');
            Route::post('profile-update', 'profileUpdate');
            Route::post('logout', 'logout');
        });
    
        //Product Actions
        Route::controller(ProductsController::class)->group(function(){
            Route::get('products', 'productsList');
        });
        
    });
});
