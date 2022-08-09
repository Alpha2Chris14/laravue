<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function login(Request $request){
        $request->validate([
            'email'=>'required|string',
            'password'=>'required|string',
        ]);

        $user = User::where("email",$request->email)->first();

        if(!$user || !Hash::check($request->password,$user->password) ){
            return response(["message"=>"Bad Attempt Login"],401);
        }

        $token = $user->createToken('myAppToken')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token
        ];
        return response($response,201);
    }



    public function logout(){
        auth()->user()->tokens()->delete();
        return response(["message"=>"Logged Out"]);
    }
}
