<?php

namespace App\Repositories\UserModule\Role;

use App\Interfaces\UserModule\Role\RoleWriteInterface;
use App\Models\UserModule\Role;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RoleWriteRepository implements RoleWriteInterface
{

    use ApiResponseTrait;

    public function create($request)
    {
        if ($request['permission']) {

            $role = new Role();
            $role->name = $request->name;
            $role->is_active = true;
            $role->save();

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
            DB::commit();
            return $this->success(null, "New role created");
        } else {
            return $this->warning(null, "Please choose user permission");
        }
    }

    public function update($request, $id)
    {
        if ($request['permission']) {

            $role = Role::find($id);

            if (!$role) {
                return $this->warning(null, "Role not found");
            }

            $role->name = $request->name;
            $role->is_active = $request->is_active;
            $role->save();

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

            DB::commit();

            return $this->success(null, 'Role Updated Successfully');
        } else {
            return $this->warning(null, "Please choose user permission");
        }
    }
}
