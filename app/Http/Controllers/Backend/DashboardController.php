<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method index
     **/
    public function index(){
        return view("backend.dashboard");
    }
}
