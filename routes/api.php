<?php

use App\Http\Controllers\API\Auth\AuthenticationController;
use App\Http\Controllers\API\CNModule\CnController;
use App\Http\Controllers\API\MarketingModule\BannerController;
use App\Http\Controllers\API\MessageModule\MessageController;
use App\Http\Controllers\API\ProductModule\CategoryController;
use App\Http\Controllers\API\ProductModule\CategoryWiseProductController;
use App\Http\Controllers\API\ProductModule\ScanController;
use App\Http\Controllers\API\UserModule\PointHistoryController;
use App\Http\Controllers\API\UserModule\PointReedemController;
use App\Http\Controllers\API\UserModule\PointTransferController;
use App\Http\Controllers\API\UserModule\UserController;

use Illuminate\Support\Facades\Route;

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

Route::middleware('api')->group(function () {
    // Authentication controller
    Route::controller(AuthenticationController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });
    // Authenticated Route
    Route::controller(UserController::class)->group(function () {
        Route::get('me', 'me');
        Route::post('update-me', 'update_me');
        Route::post('change-password', 'change_password');
    });
});
