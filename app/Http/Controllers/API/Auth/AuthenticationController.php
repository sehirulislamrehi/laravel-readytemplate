<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserModule\User;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Authencation controller. Cantain the necessary method to authenticate users to the system.
 * @version v 1.0
 * @author Alimul-Mahfuz <alimulmahfuztushar@gmail.com>
 * Available methods:
 * @method JsonResponse login() logged the authentic user and issues a jwt token
 * @method JsonResponse refresh() requeire the existing Jwt and blacklisted and then issue new token
 * @method JsonResponse logout() blacklisted the token present in request header
 * @method JsonResponse respondWithToken() formated the token
 * @method JsonResponse me() return the currently authencated user in active session
 * 
 * @copyright 2023 MIS PRAN-RFL
 */

class AuthenticationController extends Controller
{
    use ApiResponseTrait;
    /**
     * Responsible to logged in user where type not equal to 'vendor-administrator'
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|numeric|digits:4',
            'vendor_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return $this->error(data: null, message: $validator->errors()->first());
        }
        try {
            $vendorId = $request->vendor_id;
            $user = User::where('phone', $request->phone)->first();
            if ($user) {
                if ($user->type !== 'vendor-administrator') {
                    $activeStatus = DB::table('vendor_users')->where('user_id', $user->id)->where('vendor_id', $vendorId)->first();
                    if ($activeStatus) {
                        if ($activeStatus->is_active) {
                            if ($user->access_token != null) {
                                try {
                                    $token = $user->access_token;
                                    JWTAuth::manager()->invalidate(new \Tymon\JWTAuth\Token($token), $forceForever = false);
                                } catch (\Throwable $th) {
                                    //throw $th;
                                }
                            }
                            if ($token = auth('api')->attempt($request->only('phone', 'password'))) {
                                $user = auth('api')->user();
                                DB::table('users')->where('id', $user->id)->update([
                                    'access_token' => $token,
                                    'updated_at' => Carbon::now()
                                ]);
                                $userpoint = DB::table('vendor_users')->where('user_id', $user->id)->where('vendor_id', $vendorId)->select('points','is_active')->get();
                                if (!$userpoint->isEmpty()) {
                                    return $this->success([
                                        'token' => $this->respondWithToken($token),
                                        'user_info' => [
                                            'id' => $user->id,
                                            'name' => $user->name,
                                            'phone' => $user->phone,
                                            'email' => $user->email,
                                            'type' => $user->type,
                                            'point' => $userpoint[0]->points ?? 0,
                                            'is_active' => $userpoint[0]->is_active ? true : false,
                                            'vendor_info' => api_vendorInfo($user->id, $vendorId)
                                        ]
                                    ], 'authorized');
                                } else {
                                    return $this->error(null, 'Something went worng');
                                }
                            } else {
                                return $this->error(null, 'Invalid credentials');
                            }
                        } else {
                            return $this->error(data: null, message: 'Account is inactive');
                        }
                    } else {
                        return $this->error(data: null, message: 'Invalid vendor id');
                    }
                } else {
                    return $this->error(data: null, message: 'Not Allowed');
                }
            } else {
                return $this->error(data: null, message: 'Someting went wrong');
            }
        } catch (\Throwable $th) {
            return $this->error(data: null, message: $th->getMessage());
        }
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        // Pass true as the first param to force the token to be blacklisted "forever".
        // The second parameter will reset the claims for the new token
        try {
            $authUser = auth('api')->user()->id;
            $newToken = auth('api')->refresh(true, true);
            DB::table('users')->where('user_id', $authUser->id)->where('vendor_id', $authUser->vendor_id)->update([
                'token' => $newToken
            ]);
            return $this->success($this->respondWithToken($newToken), 'token refreshed');
        } catch (\Throwable $th) {
            return $this->error('', $th->getMessage(), 500);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            $authUserId = auth('api')->user()->id;
            DB::table('users')->where('id', $authUserId)->update(['access_token' => null]);
            try {
                auth('api')->invalidate(true);
            } catch (\Throwable $th) {
                //throw $th;
            }
            auth('api')->logout();
            // Pass true to force the token to be blacklisted "forever"
            auth('api')->logout(true);
            return $this->success(data: null, message: 'Successfully Logout');
        } catch (\Throwable $th) {
            return $this->error(data: null, message: "Something went wrong");
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return
     */
    protected function respondWithToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }
}
