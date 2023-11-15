<?php

use App\Http\Controllers\Backend\UserModule\User\UserCoverageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserModule\User\UserController;
use App\Http\Controllers\Backend\UserModule\User\UserDebitCreditController;

//user start 
    Route::group(['prefix' => 'user'], function(){
        Route::controller(UserController::class)->group(function(){
            Route::get("/",'index')->name('user.all');
            Route::get("/data",'data')->name('user.data');
            //user add
            Route::get("/add",'add_modal')->name('user.add.modal');
            Route::post("/add",'create_user')->name('user.add');
    
            //user edit
            Route::get("/edit/{id}",'edit')->name('user.edit');
            Route::patch("/edit/{id}",'update')->name('user.update');
    
            //User reset password by super admin
            Route::get("/reset/passowrd/{id}",'reset_password')->name('user.reset.password');
            Route::post("/reset/passowrd/{id}",'update_password')->name('user.update.password');
            

        });

    }); 
    //user end


?>