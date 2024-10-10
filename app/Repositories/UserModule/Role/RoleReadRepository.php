<?php

namespace App\Repositories\UserModule\Role;

use App\Interfaces\UserModule\Role\RoleReadInterface;
use App\Models\UserModule\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleReadRepository implements RoleReadInterface{

    public function get_all_role_data(){
        return Role::select("id", "name", "is_active");
    }

    public function get_active_role_data(){
        return Role::select("id", "name", "is_active")->where("is_active", true);
    }

    public function role_datatable($roles){
        return DataTables::of($roles)
        ->addIndexColumn()
        ->order(function($roles) {
            $roles->orderBy('id', 'desc');  // Apply ordering here
        })
        ->rawColumns(['action', 'is_active'])
        ->editColumn('is_active', function (Role $role) {
            if ($role->is_active == true) {
                return '<p class="badge badge-success">Active</p>';
            } else {
                return '<p class="badge badge-danger">Inactive</p>';
            }
        })
        ->addColumn('action', function (Role $role) {
            return '
            ' . (can("roles") ? '
                <button type="button" data-content="' . route('role.edit', $role->id) . '" data-target="#largeModal" class="btn btn-outline-dark" data-toggle="modal">
                    Edit
                </button>
            ' : '') . '
        ';
        })
        ->make(true);
    }

    public function get_role_by_id($id){
        return Role::where("id",$id)->first();
    }
}

?>