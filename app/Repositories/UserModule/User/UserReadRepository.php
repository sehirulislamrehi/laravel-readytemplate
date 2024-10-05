<?php

namespace App\Repositories\UserModule\User;

use App\Interfaces\UserModule\User\UserReadInterface;
use App\Models\UserModule\User;
use App\Traits\FilePathTrait;
use Yajra\DataTables\Facades\DataTables;

class UserReadRepository implements UserReadInterface
{

    use FilePathTrait;

    public function get_all_user_data()
    {
        return User::orderBy('id', 'desc')->select("id", "name", "email", "phone", "is_active", "role_id", "image")->with("role");
    }

    public function get_active_user_data()
    {
        return User::orderBy('id', 'desc')->select("id", "name", "email", "phone", "is_active", "role_id", "image")->where("is_active", true)->with("role");
    }

    public function user_datatable($user)
    {
        return DataTables::of($user)
            ->addIndexColumn()
            ->rawColumns(['action', 'is_active', 'role_id', 'image'])
            ->editColumn('image', function (User $user) {
                if ($user->image == null) {
                    $src = asset("images/profile/user.png");
                } else {
                    $src = asset($this->get_file_path("profile")) . '/' . $user->image;
                }

                return "
                    <img src='$src' width='25px' style='border-radius: 100%'>
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
}
