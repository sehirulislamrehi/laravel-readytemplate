<?php

//check user access permission function start

use App\Models\UserModule\User;

function can($can)
{
    if (auth('web')->check() && auth('web')->user()->is_super_admin == false) {
        foreach (auth('web')->user()->role->permission as $permission) {
            if ($permission->key == $can) {
                return true;
            }
        }
        return false;
    }
    return back();
}
//check user access permission function end


//unauthorized text start
function unauthorized()
{
    return "You are not authorized for this";
}
//unauthorized text end
