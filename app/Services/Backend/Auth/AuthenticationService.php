<?php

namespace App\Services\Backend\Auth;

use App\Models\UserModule\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class AuthenticationService
{

     use ApiResponseTrait;

     public function do_login($request)
     {
          $user = User::where("email", $request->email)->first();

          if ($user) {
               if ($user->is_active == true) {
                    $credentials = [
                         'email' => $request['email'],
                         'password' => $request['password'],
                    ];
                    if (auth('web')->attempt($credentials, true)) {
                         Auth::guard('web')->login($user);
                         return $this->location_reload(null, "Login successfull. Redirecting please wait...", true, route('dashboard'));
                    } else {
                         return $this->warning(null, "Invalid Credentials");
                    }
               } else {
                    return $this->warning(null, "Your Account is temporary disabled. Please contact with system administrator");

               }
          } else {
               return $this->warning(null, "No user found with the given email address");

          }
     }

     public function do_logout()
     {
          if (auth('web')->check()) {
               $user = auth('web')->user();
               Auth::guard('web')->logout($user);
          }

          return [
               "status" => true,
               "message" => "Logout successfull",
               "data" => [
                    "route" => route('login.page')
               ],
          ];
     }
}
