<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{

    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method do_login
     **/
    public function do_logout()
    {
        if( auth('web')->check() ){
            $user = auth('web')->user();
            Auth::guard('web')->logout($user);
        }

        return redirect()->route('login.page');
    }

}
