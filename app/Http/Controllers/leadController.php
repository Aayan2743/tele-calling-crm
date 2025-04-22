<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\plan;
use App\Models\lead;
use App\Models\phonenumber;
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
use App\Imports\PhoneImport;
use App\Imports\PhoneAutoImport;
use Maatwebsite\Excel\Facades\Excel;

class leadController extends Controller
{
    //

    public function add_lead(Request $request){

        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'leadname'=> 'required',
            'leadphone' => [
                'required',
                'digits:10',
                // Rule::unique('phonenumbers')->where(function ($query) {
                //     return $query->where('company_id', auth()->user()->company_id);
                // }),
            ],
           
        ]);

        if ($validator->fails()){
            return response()->json([
             'status'=>false,
             'errors'=> $validator->errors(),
            ],422);
         }

        
         $user_company_id = Auth::user()->company_id;
         
 
         $user = lead::create([
             'number'=> $request->leadphone,
             'staff_id'=> $request->staff,
             'name'=> $request->leadname,
            //  'active_status'=> $request->status,
             'company_id'=> $user_company_id,
             'lead_source'=> $request->leadsource,
             'lead_industry'=> $request->leadindustry,
             'email'=> $request->email,
            
         ]);

         if($user){
          
            return response()->json([
                'status'=>true,
                'message'=>'Lead Added  Successfully...!'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Some thing went wrong...!'
            ]);
        }

    }

    public function show_leads(){
      
        $company_id=Auth::user()->company_id;
     

        $leads = Lead::with('staff')
        ->where('company_id', $company_id)
        ->orderBy('id', 'desc')
        ->get()
        ->map(function($lead) {
        return [
            'id' => $lead->id,
            'number' => $lead->number ?? "N/A",
            'name' => $lead->name ?? "N/A",
            'lead_source' => $lead->lead_source ?? "N/A",
            'lead_stage' => $lead->lead_stage ?? "N/A",
            'lead_industry' => $lead->lead_industry ?? "N/A",
            'email' => $lead->email ?? "N/A",
            'created_at' => $lead->created_at ?? "N/A",
            'description' => $lead->description ?? "N/A",
          

            // Include assigned staff info
            'assigned_staff' => $lead->staff ? [
                'id' => $lead->staff->id,
                'name' => $lead->staff->name,
                'image' => asset('storage/' . $lead->staff->profile_image),
                'email' => $lead->staff->email,
                'phone' => $lead->staff->phone,
            ] : null,
        ];
    });
       

    //    dd($leads);
        return response()->json($leads);
    }


    public function update_lead(Request $request){
       
        // dd($request->all());
        
         $user_company_id = Auth::user()->company_id;
         

         $update_lead=lead::where('id', $request->edit_id)->update([
            'number'=>$request->edit_number,
            'staff_id'=>$request->editstaff,
            'name'=>$request->edit_name,
            'lead_source'=>$request->edit_lead_source,
            'lead_industry'=>$request->edit_lead_industry,
            'email'=>$request->edit_email,
            'description'=>$request->editdescription,

         ]);
 
         

         if($update_lead){
          
            return response()->json([
                'status'=>true,
                'message'=>'Lead Upated  Successfully...!'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Some thing went wrong...!'
            ]);
        }
    }


    public function viewlead($id){
        $lead = Lead::with('staff')->findOrFail($id);
        //   dd( $lead->staff->profile_image);
        //   dd( $lead);
        $firstLetter = strtoupper(substr($lead->name, 0, 1));

    return view('leads-details',compact('lead','firstLetter'));
    }
}
