<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\plan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    public function index(Request $request){

    return view('manage-users');

    }


    public function getUsers(Request $request)
        {
            // $users = User::select([
            //     'id', 'name', 'email', 'phone', 'created_at', 'active_status', 'profile_image'
            // ])->get();

           $company_id=Auth::user()->company_id;
        //    dd($company_id);
            // return response()->json(['data' => $users]);


            $users =  User::orderBy('id', direction: 'desc')->where('company_id',$company_id)->get()->map(function($user) {
                return [
                    'id' => $user->id,
                    'customer_name' => $user->name,
                    'customer_image' => asset('storage/'.$user->profile_image), // adjust as needed
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'status' => $user->active_status,
                    'role' => $user->role,
                ];
            });
            
           
            return response()->json($users);
        }


    public function plans(){

        $plans=plan::get();

        return view('membership-plans',compact('plans'));
    }

    public function store(Request $request){
    //    dd($request->all());
       
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'email'=> 'required|email|unique:users,email',
            'phone'=> 'required|digits:10|unique:users,phone',
            'password'=> 'required|min:6',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()){
            return response()->json([
             'status'=>false,
             'errors'=> $validator->errors(),
            ],422);
         }

         $imagePath = null;

         if ($request->hasFile('file')) {
            $imagePath = $request->file('file')->store('uploads/users', 'public'); // storage/app/public/uploads/users
        }
 
         $user = User::create([
             'email'=> $request->email,
             'phone'=> $request->phone,
             'name'=> $request->name,
             'password'=> Hash::make($request->password),
             'role'=> $request->role,
             'active_status'=> $request->status,
             'company_id'=>Auth()->user()->company_id,
             'profile_image'      => $imagePath, // assuming 'image' column exists in users table
         ]);

         if($user){
          
            return response()->json([
                'status'=>true,
                'message'=>'Staff Created Successfully...!'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Staff Created Successfully...!'
            ]);
        }
    

    }

    public function update(Request $request){
            // dd($request->all());
            $user = User::find($request->input('edit-id'));

            // $validator = Validator::make($request->all(), [
            //     'edit-name'=> 'required',
            //     'edit-email'=> 'required|email|unique:users,email',
            //     'edit-phone'=> 'required|digits:10|unique:users,phone',
            //     'edit-password'=> 'nullable|min:6',
            //     'edit-profile-image-input' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // ]);

            $validator = Validator::make($request->all(), [
                'edit-name' => 'required|string|max:255',
                'edit-email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($user->id),
                ],
                'edit-phone' => [
                    'required',
                    'digits:10',
                    Rule::unique('users', 'phone')->ignore($user->id),
                ],
                'edit-password' => 'nullable|min:6',
                'edit-profile-image-input' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            if ($validator->fails()){
                return response()->json([
                 'status'=>false,
                 'errors'=> $validator->errors(),
                ],422);
             }
    
             $imagePath = null;
    
             if ($request->hasFile('file')) {
                $imagePath = $request->file('file')->store('uploads/users', 'public'); // storage/app/public/uploads/users
            }

            $user = User::find($request->input('edit-id'));

            if ($user) {
                $updateData = [];

                // Conditionally add each field
                if ($request->filled('edit-name')) {
                    $updateData['name'] = $request->input('edit-name');
                }

                if ($request->filled('edit-email')) {
                    $updateData['email'] = $request->input('edit-email');
                }

                if ($request->filled('edit-phone')) {
                    $updateData['phone'] = $request->input('edit-phone');
                }

                if ($request->has('edit-status')) {
                    $updateData['active_status'] = $request->input('edit-status');
                }

                if ($request->has('role')) {
                    $updateData['role'] = $request->input('role');
                }

                // For password – hash only if not empty
                if ($request->filled('edit-password')) {
                    $updateData['password'] = Hash::make($request->input('edit-password'));
                }

                // For image – update only if a new image is uploaded
                if ($request->hasFile('edit-profile-image-input')) {
                    // Get the old profile image path from the database
                    $oldImage = $user->profile_image; // Assuming the user model has the profile_image field
                
                    // Check if the old image exists and delete it
                    if ($oldImage && file_exists(storage_path('app/public/' . $oldImage))) {
                        unlink(storage_path('app/public/' . $oldImage)); // Delete the old image
                    }
                
                    // Get the uploaded file using the correct input name
                    $file = $request->file('edit-profile-image-input');
                   
                    // Store the file and get the file path
                    $path = $file->store('uploads/users', 'public'); // Store the file in 'public' disk
                    
                    // Update the profile image path in the database
                    $updateData['profile_image'] = $path;  // Store the path in your model/database field
                }


                // Now update user
                $user->update($updateData);
                return response()->json([
                    'status' => true,
                    'message' => 'User updated successfully!',
                   
                ]);
            }
            return response()->json([
                'false' => true,
                'message' => 'User not found!!',
               
            ]);



         
    
           
        
    
        }

     public function delete(){
        dd("fjgdfkg");
     }   

}
