<?php

namespace App\Http\Controllers;
use App\APIUser;
use Illuminate\Http\Request;
use Auth;
use App\Result;

class PassportController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
 
        $user = APIUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
 
        $token = $user->createToken('mLabAPIs')->accessToken;
 
        return response()->json(['_token' => $token], 200);
    }
 
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        $user = Auth::guard('api_admins')->attempt($credentials);
        if ($user) {
            $admin = APIUser::where('email', $request->email)->first();
            $token = $admin->createToken('mLabAPIs')->accessToken;
            return response()->json(['_token' => $token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }
 
    /**
     * Returns Authenticated APIUser Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
   
}
