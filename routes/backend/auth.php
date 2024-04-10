<?php

use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

Route::get("",[LoginController::class,"index"])->name("login.page");
Route::post("do-login",[LoginController::class,"do_login"])->name("do.login");
Route::post("do-logout",[LogoutController::class,"do_logout"])->name("do.logout");


?>