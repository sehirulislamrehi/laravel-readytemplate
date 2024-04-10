<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserModule\User;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    
    use ApiResponseTrait;


    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method index
     **/
    public function index(){
        if (auth('web')->check()) {
            return redirect()->route("dashboard");
        } else {
            return view("backend.auth.login");
        }

    }

    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method do_login
     **/
    public function do_login(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'email' => 'required|exists:users,email',
                'password' => 'required',
            ]);

            if( $validator->fails() ){
                return $this->warning("", $validator->errors()->first());
            }
            else{

                $user = User::where("email", $request->email)->first();

                if($user){
                    if( $user->is_active == true ){
                        $dashboard = route('dashboard');
                        Auth::guard('web')->login($user);
                        return $this->location_reload(null,"Login successfull. Redirecting please wait...",true,$dashboard);
                    }
                    else{
                        return $this->warning(null, "Your Account is temporary disabled. Please contact with system administrator");
                    }
                }
                else{
                    return $this->warning(null, "Invalid Credentials");
                }
            }

        }
        catch( Exception $e ){
            return $this->error("", $e->getMessage());
        }

    }
}
