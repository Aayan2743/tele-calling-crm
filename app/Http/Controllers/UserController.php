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

class UserController extends Controller
{
    //
    public function index(Request $request){

        if ($request->ajax()) {
            $data = User::select(['id', 'name','email','phone', 'created_at']);
            return DataTables::of($data)
                ->addIndexColumn()
                 
                ->make(true);
        }
        return view('manage-users');
    }

    public function plans(){

        $plans=plan::get();

        return view('membership-plans',compact('plans'));
    }
}
