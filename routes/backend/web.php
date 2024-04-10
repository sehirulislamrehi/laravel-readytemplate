<?php

use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Route;

require_once "auth.php";

//backend route group start
Route::group(['prefix' => 'admindashboard', 'middleware' => 'admin_auth'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'user-module'], function(){
        require_once "user_module/role.php";
        require_once "user_module/user.php";
    });

});

?>