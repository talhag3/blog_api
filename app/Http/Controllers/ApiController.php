<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\User;

class ApiController extends Controller
{
    public function register(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:50',
            'password' => 'required'
        ]);
         
        if ($validator->fails()) {
            return [
                'msg'=>$validator->messages()->first(),
                'status'=>401
            ];
        }

        $user =  User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'api_token' => Str::random(60),
        ]);

        return [
            'msg'=>'Successfully Registered',
            'status'=>200,
            'api_token'=>$user->api_token
        ];
    }

    public function logout(Request $request) {
        $request->me->api_token= Str::random(60);
        $request->me->save();
        return [
            'msg'=>'logout',
            'status'=>'200'
        ];
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'msg'=>$validator->messages()->first(),
                'status'=>401
            ];
        }

        $user = User::where('email','=',$request->email)->first();
        
        if($user && Hash::check($request->password, $user->password)){
            return [
                'msg'=>"Successfully Login",
                'status'=>200,
                'api_token'=>$user->api_token
            ];
        }

        return [
            'msg'=>'not found',
            'status'=>404
        ];
    }
}
