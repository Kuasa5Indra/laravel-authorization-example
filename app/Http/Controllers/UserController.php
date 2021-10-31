<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register']);
    }

    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if(!Auth::attempt($request->all())){
            return response()->json(["message" => "Kredensial Salah"]);
        }

        $token = Auth::user()->createToken('API Token')->accessToken;
        return response()->json(["user" => Auth::user(), "token" => $token]);
    }

    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        if($request->query('admin')){
            $user->role = 'ADMIN';
            $user->save();
        }

        $token = $user->createToken('API Token')->accessToken;
        return response()->json(["user" => $user, "token" => $token]);
    }

    public function profile(){
        return response()->json(Auth::user());
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json(["message" => "Anda sudah keluar dari sistem"]);
    }
}
