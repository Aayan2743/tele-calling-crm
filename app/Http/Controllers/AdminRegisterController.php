<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminRegisterController extends Controller
{
    //

    public function customRegistration(){
        return view('register');
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=> 'required|email|unique:users,email',
            'phone'=> 'required|digits:10|unique:users,phone',
            'name'=> 'required|string',
            'password'=> 'required|min:6',
        ]);

        if ($validator->fails()){
           return response()->json([
            'status'=>false,
            'errors'=> $validator->errors(),
           ],422);
        }

        $user = User::create([
            'email'=> $request->email,
            'phone'=> $request->phone,
            'name'=> $request->name,
            'password'=> Hash::make($request->password),
            'role'=> "Admin",
        ]);

        if($user){
            Auth::login($user);
            return response()->json([
                'status'=>true,
                'message'=>'Customer Created Successfully...!'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Customer Created Successfully...!'
            ]);
        }


    }
    
}
