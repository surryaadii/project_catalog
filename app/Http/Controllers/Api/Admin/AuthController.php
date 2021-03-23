<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UserLoginRequest;
use JWTAuth;

class AuthController extends Controller
{
    //
    public function login(UserLoginRequest $request)
    {
        $status = false;
        $sTime = microtime(true);
        $isAllowed = false;
        $user = null;
        try {
        
            $reqData = [
                'email' => $request->get('email'),
                'password' => $request->get('password')
            ];

            if( !$token = JWTAuth::attempt($reqData) ) {
                return response()->json(['error' => 'Invalid Credentials'], 401);
            }
            $user = JWTAuth::setToken($token)->toUser();
            $status = true;
        } catch (JWTException $e) {
            return response()->json(['error' => 'Something went wrong please try again.'], 500);
        }

        return response()->json([
            'status' => $status,
            'message' => 'success',
            'data' => [
                'token'=> $token,
                'isAllowed' => $user && $user->isAdmin ?? $user->isAdmin
            ],
            'time' => microtime(true)-$sTime
        ]);
    }
}
