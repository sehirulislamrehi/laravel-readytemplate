<?php

namespace App\Repositories\UserModule\User;

use App\Interfaces\UserModule\User\UserReadInterface;
use App\Models\UserModule\User;
use App\Services\Backend\Modules\CommonModule\CommonService;
use App\Traits\FilePathTrait;
use Yajra\DataTables\Facades\DataTables;

class UserReadRepository implements UserReadInterface
{

    use FilePathTrait;
    protected $common_service;

    public function __construct(CommonService $common_service)
    {
        $this->common_service = $common_service;
    }

    public function get_all_user_data()
    {
        $auth = auth('web')->user();
        return User::orderBy('id', 'desc')->select("id", "name", "email", "phone", "is_active", "role_id", "image")->where("id","!=",$auth->id)->with("role");
    }

    public function get_active_user_data()
    {
        $auth = auth('web')->user();
        return User::orderBy('id', 'desc')->select("id", "name", "email", "phone", "is_active", "role_id", "image")->where("id","!=",$auth->id)->where("is_active", true)->with("role");
    }

    public function user_datatable($user)
    {
        return DataTables::of($user)
            ->addIndexColumn()
            ->order(function($user) {
                $user->orderBy('id', 'desc');  // Apply ordering here
            })
            ->rawColumns(['action', 'is_active', 'role_id', 'image'])
            ->editColumn('image', function (User $user) {
                

                if ($user->image == null) {
                    $image = asset("images/profile/user.png");
                } else {
                    $image = $this->common_service->get_image_link($user->image,$this->get_file_path("profile"));
                }

                return "
                    <img src='$image' width='25px' style='border-radius: 100%'>
                ";
            })
            ->editColumn('role_id', function (User $user) {
                return $user->role_id ? $user->role->name : '';
            })
            ->editColumn('is_active', function (User $user) {
                if ($user->is_active == true) {
                    return '<p class="badge badge-success">Active</p>';
                } else {
                    return '<p class="badge badge-danger">Inactive</p>';
                }
            })
            ->addColumn('action', function (User $user) {
                return '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown' . $user->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown' . $user->id . '">
                    
                        ' . (can("edit_user") ? '
                        <a class="dropdown-item" href="#" data-content="' . route('user.edit', $user->id) . '" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                            <i class="fas fa-edit"></i>
                            Edit
                        </a>
                        ' : '') . '

                        ' . (can("reset_password") ? '
                        <a class="dropdown-item" href="#" data-content="' . route('user.reset.modal', $user->id) . '" data-target="#myModal" data-toggle="modal">
                            <i class="fas fa-key"></i>
                            Reset Password
                        </a>
                        ' : '') . '

                    </div>
                </div>
                ';
            })
            ->make(true);
    }

    public function get_user_by_id($id){
        return User::where("id",$id)->select("name","email","phone","role_id","is_active","id")->first();
    }

    public function get_user_by_email($email){
        if($email){
            return User::where("email","LIKE","%".$email."%")->select("name","id","email")->take(1000)->get();
        }
        return [];
    }
}
