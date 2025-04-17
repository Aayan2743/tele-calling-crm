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

class LoginController extends Controller
{
    //

    public function index(){
        return view('index');
    }


    public function login(Request $request){
        
      $validate = Validator::make($request->all(), [
        "email"=> "required|email",
        "password"=>"required|min:6|max:12",
      ]);

      if($validate->fails()){
        return response()->json([
            'status'=>false,
            'errors'=> $validate->errors(),
        ],422);
      }

        // $user = User::where('email', $request->email)->where('password', $request->password)->first();

        $user = User::where('email', $request->email)->first();
      

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user); 
          
            return response()->json(['status' => true, 'message' => 'Login successful']);
        } else {
            // Password does not match or user does not exist
            return response()->json(['status' => false, 'message' => 'Invalid credentials'], 201);
        }



    


        // dd($request->all());    
    }

    public function logout(){
        Auth::logout(); // Logs the user out
        request()->session()->invalidate(); // Invalidates the session
        request()->session()->regenerateToken(); // Regenerates CSRF token
        return redirect('/login'); // Redirect to login page
    }
    public function logout2(){
        Auth::logout(); // Logs the user out
        request()->session()->invalidate(); // Invalidates the session
        request()->session()->regenerateToken(); // Regenerates CSRF token
        return redirect('/login'); // Redirect to login page
    }

    public function forgot_password(Request $request){
        return view('forgot-password');
    }

    public function forgot_password_check(Request $request){
        $validate = Validator::make($request->all(), [
            'email'=> 'required|email'
        ]);
    
        if($validate->fails()){
            return response()->json(['status'=>false,'errors'=> $validate->errors()],422);
        }

        $email=user::where('email', $request->email)->exists();
        if(!$email){
            return response()->json(['status'=>false,'message'=> 'Email Id Not Registered'],201);
        }
        else{

            $otp = random_int(100000, 999999);
            $token = Str::random(22);
            $update = User::where('email', $request->email)->update(['otp' => $otp,'expTime'=>now()->addMinutes(5),'expToken'=> $token ]);
           
            $link = config('app.url') . '/reset-password/' . $token;
            // reset-password/XsK2Yai91YaTfrOESsdChi
            $data = [
                'name' => 'Asif Shaik',
                'link' =>  $link
            ];
        
            Mail::to('sk.asif0490@gmail.com')->queue(new ResetPasswordMail($data)); // 👈 use queue here
        
            // Log::info('Reset password email queued for: sk.asif0490@gmail.com', $data);


            return response()->json(['status'=>true,'message'=> 'Mail sent'],201);
        }
      

    }

    public function resetpassword($token){

        $user = User::where('expToken', $token)->first();

        if ($user) {
            // $expiresAt = Carbon::parse($user->expTime)->addMinutes(5);

            if (Carbon::now()->lessThan($user->expTime)) {
                // Token is valid
                return view('resetpassword', compact('user'));
                // return view('resetpassword',compact('user)'));
            } else {
                // Token expired
                return response()->json(['status'=>false,'message'=> 'Token Expired'],201);
            }
        } else {
            // Invalid token
            return response()->json(['status'=>false,'message'=> 'Token Invalid'],201);
        }



       

    }

    public function updatePassword(Request $request){
           
     
        $validate=Validator::make($request->all(), [
                'password'=>'required|min:6'
            ]);

            if( $validate->fails() ){
                return response()->json(['status'=>false,'errors'=> $validate->errors()],422);
            }

            $user = User::where('email',operator: $request->email)->update([
              'password' => Hash::make($request->password),
              'expToken'=>null,
              'expTime'=>null,
              'otp'=>null,
            ]);

            if( $user){
                return response()->json(['status'=>true,'message'=> 'password updated'],200);

            }
    }



}
