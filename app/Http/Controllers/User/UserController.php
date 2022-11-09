<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return view('profile');
    }
    public function update(Request $request){
        
        $userr = User::find(auth()->user()->id);
        $userr -> tnumber = $request -> tnumber;
        $userr -> address = $request -> address;
        $userr -> gender = $request -> gender;
        $userr -> nationality = $request -> nationality;
        $userr -> IDno = $request -> IDno;
        $userr -> ename = $request -> ename;
        $userr -> etnumber = $request -> etnumber;
        $userr->save();

        return redirect('profile')->with('status','User details edited successfully');
    }
    public function passwordCreate(){

        return view('change-password');
    }

    public function changePassword(Request $request){
        $request->validate([
            'current_password' => ['required','string'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $currentPasswordStatus = Hash::check($request->current_password, auth()->user()->password);
        if($currentPasswordStatus){

            User::findOrFail(Auth::user()->id)->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->back()->with('message','Password Updated Successfully');

        }else{

            return redirect()->back()->with('message','Current Password does not match with Old Password');
        }
    
    }
}