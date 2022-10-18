<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        try {
            $request->validate([
                'name'=> 'required|string',
                'email'=> 'required|email',
                'password'=>'required|string',
                'admin_code'=>'string'
            ]);
            $user = User::create([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=>bcrypt($request->password)
            ]);

            if ($request->admin_code && $request->admin_code == env('ADMIN_CODE')) {
                $user->assignRole('admin');
            }else {
                $user->assignRole('customer');
            }

            return response()->json([
                'message'=>'Successfully created user!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error'=>$e->getMessage()
            ]);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 3600
        ]);
    }

    public function me()
    {
        $user = User::where('id', Auth::user()->id)->with(['roles','roles.permissions'])->first();
        return response()->json($user);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    
}
