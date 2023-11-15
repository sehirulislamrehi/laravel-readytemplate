<?php

namespace App\Http\Middleware;

use App\Models\UserModule\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string|null
     */
    public function handle(Request $request, Closure $next)
    {

        if (auth('super_admin')->check()) {
            return $next($request);
        } 
        elseif( auth('web')->check() ){
            /**
             * User other then superadmin can login if the that user is vendor-administrator type and have an active role
             */
            if( auth('web')->user()->type == 'vendor-administrator' ){
                $user = auth('web')->user();
                if( $user->vendor && $user->vendor->is_active == true ){
                    $user = User::find(auth('web')->user()->id);
                    $user->lastActive = date('Y-m-d H:i:s');
                    $user->save();
                    return $next($request);
                }
            }
            else {
                Auth::logout();
                return redirect()->route('login.show');
            }
        }
        else {

            return redirect()->route('login.show');
        }
    }
}