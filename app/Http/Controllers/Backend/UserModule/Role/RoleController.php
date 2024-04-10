<?php

namespace App\Http\Controllers\Backend\UserModule\Role;

use App\Http\Controllers\Controller;
use App\Models\UserModule\Module;
use App\Models\UserModule\Role;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use function Laravel\Prompts\warning;

class RoleController extends Controller
{

    use ApiResponseTrait;

    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method index
     **/
    public function index()
    {
        if (can('roles')) {
            return view("backend.modules.user_module.role.index");
        } else {
            return view("errors.404");
        }
    }


    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method data
     **/
    public function data()
    {
        if (can('roles')) {
            $role = Role::select("id", "name", "is_active");

            return DataTables::of($role)
                ->addIndexColumn()
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
        } else {
            return view("errors.404");
        }
    }

    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method add_modal
     **/
    public function add_modal()
    {
        try {
            if (can("roles")) {
                $modules = Module::orderBy("position", "asc")->select("id", "name", "key")->with("permission")->get();
                return view("backend.modules.user_module.role.modals.add", compact("modules"));
            } else {
                return unauthorized();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method add
     **/
    public function add(Request $request)
    {
        if (can('roles')) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:roles,name',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            } else {
                try {
                    if ($request['permission']) {

                        $role = new Role();
                        $role->name = $request->name;
                        $role->is_active = true;

                        if ($role->save()) {

                            $data = [];
                            foreach ($request['permission'] as $permission) {
                                array_push($data, [
                                    'role_id' => $role->id,
                                    'permission_id' => $permission,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ]);
                            }

                            DB::table('permission_role')->insert($data);

                            return $this->success(null, "New role created");
                        }
                    } else {
                        return $this->warning(null, "Please choose user permission");
                    }
                } catch (Exception $e) {
                    return $this->error(null, $e->getMessage());
                }
            }
        } else {
            return $this->warning(null, unauthorized());
        }
    }

    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method add_modal
     **/
    public function edit($id)
    {
        if (can('roles')) {

            $role = Role::where("id", $id)->first();

            if ($role) {
                $modules = Module::orderBy("position", "asc")->select("id", "name", "key")->with("permission")->get();
                return view("backend.modules.user_module.role.modals.edit", compact('role', 'modules'));
            } else {
                return "No role found";
            }
        } else {
            return unauthorized();
        }
    }

    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024 MIS
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method update
     **/
    public function update(Request $request, $id)
    {
        if (can('roles')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            } else {
                try {
                    if ($request['permission']) {

                        $role = Role::find($id);

                        if (!$role) {
                            return $this->warning(null, "Role not found");
                        }

                        $role->name = $request->name;
                        $role->is_active = $request->is_active;

                        if ($role->save()) {

                            $data = [];
                            foreach ($request['permission'] as $permission) {
                                array_push($data, [
                                    'role_id' => $role->id,
                                    'permission_id' => $permission,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ]);
                            }

                            DB::statement("DELETE FROM permission_role WHERE role_id = $role->id");
                            DB::table('permission_role')->insert($data);

                            return $this->success(null, 'Role Updated Successfully');
                        }
                    } else {
                        return $this->warning(null, "Please choose user permission");
                    }
                } catch (Exception $e) {
                    return $this->error(null, $e->getMessage());
                }
            }
        } else {
            return $this->warning(null, unauthorized());
        }
    }
}
