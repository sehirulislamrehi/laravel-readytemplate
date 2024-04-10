<?php

namespace App\Http\Controllers\Backend\UserModule\User;

use App\Http\Controllers\Controller;
use App\Models\UserModule\BuySell;
use App\Models\PriceCoverage\Prefix;
use App\Models\UserModule\Role;
use App\Models\Reports\Transaction;
use App\Models\UserModule\User;
use App\Models\UserModule\Validity;
use App\Traits\ApiResponseTrait;
use App\Traits\FilePathTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class UserController extends Controller
{

    use ApiResponseTrait, FilePathTrait;

    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method index
     **/
    public function index(){
        if( can('all_user') ){
            return view("backend.modules.user_module.user.index");
        }else{
            return view("errors.403");
        }
    }

    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method data
     **/
    public function data(){
        if( can('all_user') ){
            
            $user = User::orderBy('id', 'desc')->select("id","name","email","phone","is_active","role_id","image")->with("role");
            
            return DataTables::of($user)
            ->addIndexColumn()
            ->rawColumns(['action','is_active','role_id','image'])
            ->editColumn('image', function(User $user){
                if( $user->image == null ){
                    $src = asset("images/profile/user.png");
                }
                else{
                    $src = asset($this->get_file_path("profile")) .'/'. $user->image;
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
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown'.$user->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown'.$user->id.'">
                    
                        '.( can("edit_user") ? '
                        <a class="dropdown-item" href="#" data-content="'.route('user.edit',$user->id).'" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                            <i class="fas fa-edit"></i>
                            Edit
                        </a>
                        ': '') .'

                        '.( can("reset_password") ? '
                        <a class="dropdown-item" href="#" data-content="'.route('user.reset.modal',$user->id).'" data-target="#myModal" data-toggle="modal">
                            <i class="fas fa-key"></i>
                            Reset Password
                        </a>
                        ': '') .'

                    </div>
                </div>
                ';
            })
            ->make(true);
        }else{
            return unauthorized();
        }
    }


   /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method add_modal
     **/
    public function add_modal(){
        try{
            if( can('add_user') ){
                $roles = Role::select("id","name")->where("is_active", true)->get();

                return view("backend.modules.user_module.user.modals.add", compact("roles"));
            }
            else{
                return unauthorized();
            }
        }
        catch( Exception $e ){
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
    public function add(Request $request){
        if( can('add_user') ){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'role_id' => 'required|exists:roles,id',
                'phone' => 'required|numeric',
                'password' => 'required|confirmed',
            ]);
            

           if( $validator->fails() ){
               return response()->json(['errors' => $validator->errors()] ,422);
           }else{
                try{
                    $user = new User();
                    $user->name = $request->name;
                    $user->email  = $request->email;
                    $user->phone = $request->phone;
                    $user->role_id = $request->role_id;
                    $user->password = Hash::make($request->password);
                    $user->is_active = true;
                    
                    if( $user->save() ){
                        return $this->success(null, 'New user created');
                    }

                }catch( Exception $e ){
                    return $this->error(null, $e->getMessage());
                }
           }
        }else{
            return $this->warning(null,unauthorized());
        }
    }

    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method edit
     **/
    public function edit($id){
        try{
            if( can("edit_user") ){
                $user = User::where("id",$id)->select("name","email","phone","role_id","is_active","id")->first();
    
                if(!$user){
                    return "User not found";
                }
    
                $roles = Role::select("id","name")->where("is_active", true)->get();
    
                return view("backend.modules.user_module.user.modals.edit", compact("user","roles"));
            }
            else{
                return unauthorized();
            }
        }
        catch( Exception $e ){
            return $e->getMessage();
        }
    }

    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method update
     **/
    public function update(Request $request, $id){
        if( can('edit_user') ){
            
            $validator = Validator::make($request->all(),[
                'is_active' => 'required',
                'name' => 'required',
                'phone' => 'required|numeric',
                'role_id' => 'required|exists:roles,id',
           ]);

           if( $validator->fails() ){
               return response()->json(['errors' => $validator->errors()] ,422);
           }else{
                try{
                    $user = User::find($id);

                    if(!$user){
                        return $this->warning(null, "User not found");
                    }

                    $user->is_active = $request->is_active;
                    $user->name = $request->name;
                    $user->phone = $request->phone;
                    $user->role_id = $request->role_id;

                    if( $user->save() ){
                        return $this->success(null, "Account updated");
                    }
                }catch( Exception $e ){
                    return $this->error(null, $e->getMessage());
                }
           }
        }else{
            return $this->warning(null, unauthorized());
        }
    }

    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method reset_modal
     **/
    public function reset_modal($id){
        try{
            if( can("reset_password") ){
                $user = User::find($id);
                if(!$user){
                    return "No user found";
                }
                return view("backend.modules.user_module.user.modals.reset", compact("user"));
            }
            else{
                return unauthorized();
            }
        }
        catch( Exception $e ){
            return $e->getMessage();
        }
    }

    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method reset_modal
     **/
    public function reset($id, Request $request){
        if( can("reset_password") ){
            $validator = Validator::make($request->all(),[
                'password' => 'required|confirmed',
           ]);

           if( $validator->fails() ){
               return response()->json(['errors' => $validator->errors()] ,422);
           }else{
                try{
                    $user = User::find($id);

                    if(!$user){
                        return $this->warning(null, "User not found");
                    }

                    $user->password = Hash::make($request->password);

                    if( $user->save() ){
                        return $this->success(null, "Password updated");
                    }
                }catch( Exception $e ){
                    return $this->error(null, $e->getMessage());
                }
           }
            
        }
        else{
            return $this->warning(null,unauthorized());
        }
    }


    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method edit_my_profile_page
     **/
    public function edit_my_profile_page(){
        try{
            $auth = auth('web')->user();
            $get_file_path = asset($this->get_file_path("profile"));
            $image = $get_file_path .'/'. (isset($auth->image) ? $auth->image : 'user.png');

            return view("backend.modules.user_module.user.pages.edit_my_profile", compact("auth","image"));
        }
        catch( Exception $e ){
            return back()->with('error', $e->getMessage());
        }
    }
    

    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method edit_my_profile
     **/
    public function edit_my_profile(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:users,email,'. auth('web')->user()->id,
            'phone' => 'required|numeric',
       ]);

       if( $validator->fails() ){
           return response()->json(['errors' => $validator->errors()] ,422);
       }else{
            try{
                $user = User::find(auth('web')->user()->id);

                if(!$user){
                    return $this->warning(null, "User not found");
                }

                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->phone;

                if ($request->file) {
                    $profile_image_path = public_path($this->get_file_path("profile"));
                    if (File::exists($profile_image_path . $user->image)) {
                        File::delete($profile_image_path . $user->image);
                    }
                    $image = $request->file('file');
                    $img = time() . Str::random(5) . '.' . $image->getClientOriginalExtension();
                    $image->move($profile_image_path, $img);
                    $user->image = $img;
                }

                if( $user->save() ){
                    return $this->success(null, "Account updated");
                }
            }catch( Exception $e ){
                return $this->error(null, $e->getMessage());
            }
       }
    }


    /**
     *** WARNING: !!! While changing the function please, care with extra caution. !!!
     *** WARNING: !!! Don't forget to use proper validation and error handling. !!!
     *** @copyright 2024
     *** @author Md Sehirul Islam Rehi <mdsehirulislamrehi@gmail.com>
     *** @method edit_my_password
     **/
    public function edit_my_password(Request $request){
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'password' => 'required|confirmed',
       ]);

       if( $validator->fails() ){
           return response()->json(['errors' => $validator->errors()] ,422);
       }else{
            try{
                $user = User::find(auth('web')->user()->id);

                if(!$user){
                    return $this->warning(null, "User not found");
                }

                if( Hash::check($request->old_password, $user->password) ){
                    $user->password = Hash::make($request->password);
                    if( $user->save() ){
                        return $this->success(null, "Password changed");
                    }
                }
                else{
                    return $this->warning(null, "Old password not matched");
                }

                
            }catch( Exception $e ){
                return $this->error(null, $e->getMessage());
            }
       }
    }
}