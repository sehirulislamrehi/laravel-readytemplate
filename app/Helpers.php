<?php

//check user access permission function start
use App\Models\SettingsModule\AppInfo;
use App\Models\SettingsModule\Vendor;
use App\Models\UserModule\Module;
use Illuminate\Support\Facades\DB;

function can($can)
{
    if (auth('web')->check()) {
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
    return "You are not authorized for this request";
}
//unauthorized text end

//mail from start
function mail_from()
{
    return "test@sehirulislamrehi.com";
}
//mail from end

function mobileNumberValidate($mobile)
{

    if (strlen($mobile) > 11) {
        $mobile = substr($mobile, -11);
    }
    return $mobile;
}

/**
 * Return the application logo from AppInfo models
 *
 * @return string
 */
function get_logo(): string
{
    $appinfo = AppInfo::find(1);
    if ($appinfo) {
        $logo_path = "images/info/" . $appinfo->logo;
    } else {
        $logo_path = "images/info/default_logo.png";
    }
    return $logo_path;
}

function get_favicon(): string
{
    $favicon = AppInfo::find(1);
    if ($favicon->fav != null) {
        return "images/info/$favicon->fav";
    } else {
        return "images/info/fav.png";
    }
}

/**
 * Return the active class for styling for module if it's sub module is activne
 *
 * @param Module $module
 * @param string $currentRouteName
 * @return string
 */
function get_sub_module(Module $module, $currentRouteName): string
{
    $submodules = $module->sub_module()->pluck('route')->toArray();
    if (in_array($currentRouteName, $submodules)) {
        return 'active';
    } else {
        return '';
    }
}



