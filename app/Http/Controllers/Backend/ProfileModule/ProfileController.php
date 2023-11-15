<?php

namespace App\Http\Controllers\Backend\ProfileModule;

use App\Http\Controllers\Controller;
use App\Models\UserModule\SuperAdmin;
use App\Models\UserModule\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
class ProfileController extends Controller
{
    public function index($id)
    {
        if( auth('super_admin')->check() ){
            $user = SuperAdmin::where('email', $id)->first();
        }
        elseif( auth('web')->check() ){
            $user = User::where('id', $id)->first();
        }
        return view('backend.modules.profile_module.index');
    }

    public function edit_profile(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|numeric|unique:users,phone,'.$id,
            'email' => 'required|unique:users,email,'.$id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            if( auth('super_admin')->check() ){
                $user = SuperAdmin::find($id);
            }
            elseif( auth('web')->check() ){
                $user = User::find($id);
            }
            
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;

            if( $request->image ){
                if( File::exists('images/profile/'. $user->image) ){
                    File::delete('images/profile/'. $user->image);
                }
                $image = $request->file('image');
                $img = time().Str::random(12).'.'.$image->getClientOriginalExtension();
                $location = public_path('images/info/');
                $image->move($location, $img);
                $user->image = $img;
            }

            $user->update();
            if ($user->save()) {
                return response()->json(['success' => 'Profile Information Updated Successfully'], 200);
            }
        }
    }

    public function change_password(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {

            if( auth('super_admin')->check() ){
                $user = SuperAdmin::find($id);
            }
            else{
                $user = User::find($id);
            }

            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->password);
                if ($user->save()) {
                    $url = route('profile.show', $id);

                    return response()->json(['success' => 'Password Updated'], 200);
                }
            } else {
                return response()->json(['error' => 'Old Password did not match'], 200);
            }
        }
    }
}