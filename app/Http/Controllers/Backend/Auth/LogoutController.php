<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Services\Backend\Auth\AuthenticationService;

class LogoutController extends Controller
{

    protected AuthenticationService $authentication_service;

    public function __construct(AuthenticationService $authentication_service)
    {
        $this->authentication_service = $authentication_service;
    }

    public function do_logout()
    {
        $this->authentication_service->do_logout();        
        return redirect()->route('login.page');
    }

}
