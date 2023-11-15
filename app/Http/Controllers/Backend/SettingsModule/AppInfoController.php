<?php

namespace App\Http\Controllers\Backend\SettingsModule;

use App\Http\Controllers\Controller;
use App\Models\SettingsModule\AppInfo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AppInfoController extends Controller
{
    //index function start
    public function index()
    {
        if (can("app_info")) {
            $app_info = AppInfo::first();
            return view("backend.modules.setting_module.app_info.index", compact("app_info"));
        } else {
            return view("errors.403");
        }
    }
    //index function end

    //update function start
    public function update(Request $request, $id)
    {
        if (can("edit_app_info")) {
            try {
                $app_info = AppInfo::find($id);

                if ($request->logo) {
                    if (File::exists('images/info/' . $app_info->logo)) {
                        File::delete('images/info/' . $app_info->logo);
                    }

                    $image = $request->file('logo');
                    $img = time() . Str::random(12) . '.' . $image->getClientOriginalExtension();
                    $location = public_path('images/info/');
                    $image->move($location, $img);
                    $app_info->logo = $img;
                }

                if ($request->fav) {
                    if (File::exists('images/info/' . $app_info->fav)) {
                        File::delete('images/info/' . $app_info->fav);
                    }
                    $image = $request->file('fav');
                    $img = time() . Str::random(12) . '.' . $image->getClientOriginalExtension();
                    $location = public_path('images/info/');
                    $image->move($location, $img);
                    $app_info->fav = $img;
                }


                $app_info->mail_from_address = $request->mail_from_address;
                $app_info->phone = $request->phone;

                if ($app_info->save()) {
                    return response()->json([
                        'status' => 'success',
                        'location_reload' => 'Information updated',
                        'data' => null
                    ], 200);
                }
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'location_reload' => 'Fatal Error',
                    'data' => null
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 'warning',
                'location_reload' => 'Something went wrong',
                'data' => null
            ], 500);
        }
    }
    //update function end
}
