<?php

namespace App\Http\Controllers\Backend\UserModule\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Modules\UserModule\Role\CreateRoleRequest;
use App\Interfaces\UserModule\Role\RoleReadInterface;
use App\Interfaces\UserModule\Role\RoleWriteInterface;
use App\Services\Backend\Modules\UserModule\RoleService;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    use ApiResponseTrait;
    protected $role_read_repository;
    protected $role_write_repository;
    protected $role_service;

    public function __construct(RoleReadInterface $role_read_interface, RoleWriteInterface $role_write_interface, RoleService $role_service)
    {
        $this->role_read_repository = $role_read_interface;
        $this->role_write_repository = $role_write_interface;
        $this->role_service = $role_service;
    }

    public function index()
    {
        if (can('roles')) {
            return view("backend.modules.user_module.role.index");
        } else {
            return view("errors.403");
        }
    }

    public function data()
    {
        if (can('roles')) {
            $roles = $this->role_read_repository->get_all_role_data();
            return $this->role_read_repository->role_datatable($roles);
        } else {
            return view("errors.403");
        }
    }

    public function add_modal()
    {
        try {
            if (can("roles")) {
                $modules = $this->role_service->get_modules_for_role();
                return view("backend.modules.user_module.role.modals.add", compact("modules"));
            } else {
                return unauthorized();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function add(CreateRoleRequest $request)
    {
        try {
            if (can('roles')) {
                DB::beginTransaction();
                return $this->role_write_repository->create($request);
            } 
            else {
                return $this->warning(null, unauthorized());
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error(null, $e->getMessage());
        }
    }


    public function edit($id)
    {
        if (can('roles')) {
            $role = $this->role_read_repository->get_role_by_id($id);
            if ($role) {
                $modules = $this->role_service->get_modules_for_role();
                return view("backend.modules.user_module.role.modals.edit", compact('role', 'modules'));
            } else {
                return "No role found";
            }
        } else {
            return unauthorized();
        }
    }


    public function update(Request $request, $id)
    {
        try {
            if (can('roles')) {
                DB::beginTransaction();
                return $this->role_write_repository->update($request, $id);
            } 
            else {
                return $this->warning(null, unauthorized());
            }
        } 
        catch (Exception $e) {
            DB::rollBack();
            return $this->error(null, $e->getMessage());
        }
    }
}
