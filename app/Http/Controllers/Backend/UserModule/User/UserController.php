<?php

namespace App\Http\Controllers\Backend\UserModule\User;

use App\Http\Controllers\Controller;
use App\Models\SettingsModule\Vendor;
use App\Models\UserModule\Role;
use App\Models\UserModule\User;
use App\Models\UserModule\VendorUser;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    //if add new user type, please add at the end
    private $paginate = 20;

    //index start
    public function index(Request $request)
    {
        if (can('all_user')) {
            
            $query_users = User::orderBy("id","desc")->select("id","name","email","phone","is_active");
            $users = $query_users->paginate($this->paginate);


            return view('backend.modules.user_module.user.index', compact('users'));
        } else {
            return view('errors.403');
        }
    }

}
