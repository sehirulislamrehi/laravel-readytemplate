<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Services\Backend\Auth\AuthenticationService;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    
    use ApiResponseTrait;

    protected AuthenticationService $authentication_service;

    public function __construct(AuthenticationService $authentication_service)
    {
        $this->authentication_service = $authentication_service;
    }

    public function index(){
        if (auth('web')->check()) {
            return redirect()->route("dashboard");
        } else {
            return view("backend.auth.login");
        }
    }

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
                return $this->authentication_service->do_login($request);
            }
        }
        catch( Exception $e ){
            return $this->error("", $e->getMessage());
        }

    }
}
