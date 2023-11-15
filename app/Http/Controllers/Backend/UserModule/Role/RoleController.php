<?php

namespace App\Http\Controllers\Backend\UserModule\Role;

use App\Http\Controllers\Controller;
use App\Models\UserModule\Module;
use App\Models\UserModule\Role;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    //index start
    public function index(Request $request){
        if( can('roles') ){
            return view("backend.modules.user_module.role.index");
        }else{
            return view("errors.403");
        }
    }

    //data
    public function data(Request $request){
        if( can('roles') ){

            $query = Role::select("id","name","is_active");

            $role = $query->get();
            
            return DataTables::of($role)
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
                '.( can("edit_roles") ? '
                <button type="button" data-content="'.route('role.edit',$role->id).'" data-target="#largeModal" class="btn btn-outline-dark" data-toggle="modal">
                    Edit
                </button>
                ': '') .'

                ';
            })
            ->make(true);
        }else{
            return unauthorized();
        }
        
    }

    //add modal
    public function add_modal(){
        if( can("add_roles") ){

            $modules = Module::orderBy("position","asc")->select("id","name","key")->with("permission")->get();

            if( auth('super_admin')->check() ){
                return view("backend.modules.user_module.role.modals.add", compact("modules"));
            }
            else{

                return view("backend.modules.user_module.role.modals.add", compact('modules'));
            }

        }
        else{
            return unauthorized();
        }
    }

    //add start
    public function add(Request $request){
        if( can('add_roles') ){
            
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);
    
            if( $validator->fails() ){
                return response()->json(['errors' => $validator->errors()], 422);
            }else{
                try{
                    if( $request['permission'] ){

                        $role = new Role();
                        $role->name = $request->name;
                        $role->is_active = true;

                        if( $role->save() ){

                            $data = [];
                            foreach( $request['permission'] as $permission ){
                                array_push($data,[
                                    'role_id' => $role->id, 
                                    'permission_id' => $permission, 
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ]);
                            }

                            DB::table('permission_role')->insert($data);
                            return response()->json([
                                'status' => 'success',
                                'message' => 'New role added'
                            ], 200);
                        }
                    }
                    else{
                        return response()->json(['status'=>'warning','message' => 'Please choose user permission.'],200);
                    }
                }
                catch(Exception $e){
                    return response()->json(['status'=>'error','message' => $e->getMessage()],200);
                }
            }
        }else{
            return response()->json(['status'=>'error','message' => unauthorized()], 200);
        }
        
    }

    //role edit modal
    public function edit($id){
        if( can('edit_roles') ){

            $role = Role::where("id",$id)->first();
            $modules = Module::orderBy("position","asc")->select("id","name","key")->with("permission")->get();

            if( auth('super_admin')->check() ){

                return view("backend.modules.user_module.role.modals.edit", compact('role','modules'));
            }
            else{
                return view("backend.modules.user_module.role.modals.edit", compact('role','modules'));
            }
            
        }
        else{
            return unauthorized();
        }
        
    }

    //update start
    public function update(Request $request, $id){
        if( can('edit_roles') ){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);
    
            if( $validator->fails() ){
                return response()->json(['errors' => $validator->errors()], 422);
            }else{
                try{
                    if( $request['permission'] ){

                        $role = Role::find($id);
                        $role->name = $request->name;
                        $role->is_active = $request->is_active;

                        if( $role->save() ){
                            
                            $data = [];
                            foreach( $request['permission'] as $permission ){
                                array_push($data,[
                                    'role_id' => $role->id, 
                                    'permission_id' => $permission, 
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ]);
                            }

                            DB::statement("DELETE FROM permission_role WHERE role_id = $role->id");
                            DB::table('permission_role')->insert($data);

                            return response()->json(['status' => 'success', 'message' => 'Role Updated Successfully'], 200);
                        }
                    }
                    else{
                        return response()->json(['status' => 'warning','message' => 'Please choose user permission.'],200);
                    }
                }
                catch(Exception $e){
                    return response()->json(['status' => 'error','message' => $e->getMessage()], 200);
                }
            }
        }
        else{
            return response()->json(['status' => 'warning','warning' => unauthorized()], 200);
        }
    }
}