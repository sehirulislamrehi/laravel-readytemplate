<?php

namespace App\Repositories\UserModule\User;

use App\Interfaces\UserModule\User\UserWriteInterface;
use App\Models\UserModule\User;
use App\Services\Backend\Modules\CommonModule\CommonService;
use App\Traits\ApiResponseTrait;
use App\Traits\FilePathTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserWriteRepository implements UserWriteInterface
{

    use ApiResponseTrait, FilePathTrait;
     protected $common_service;
     public function __construct(CommonService $common_service)
     {
          $this->common_service = $common_service;
     }

    public function create($request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email  = $request->email;
        $user->phone = $request->phone;
        $user->role_id = $request->role_id;
        $user->password = Hash::make($request->password);
        $user->is_active = true;
        $user->is_super_admin = false;
        $user->save();
        return $this->success(null, 'New user created');
    }

    public function update($request, $user)
    {
        $user->is_active = $request->is_active;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->role_id = $request->role_id;
        $user->save();

        return $this->success(null, 'User updated');
    }

    public function reset_password($request, $user)
    {
        $user->password = Hash::make($request->password);
        $user->save();
        return $this->success(null, "Password updated");
    }

    public function update_profile($request, $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        $file = $request->file('file');
        $folder = $this->get_file_path("profile");

        if($file){
            $filename = rand(00000,99999) .'_'. time() .'.'. $file->getClientOriginalExtension();
            if( $this->common_service->file_upload($file,$filename,$folder,null) ){
                $user->image = $filename;
            }
        }

        if ($user->save()) {
            return $this->success(null, "Account updated");
        }
    }

    public function change_my_password($request, $user)
    {
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);
            if ($user->save()) {
                return $this->success(null, "Password changed");
            }
        } else {
            return $this->warning(null, "Old password not matched");
        }
    }
}
