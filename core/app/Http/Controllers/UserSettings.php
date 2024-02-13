<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserSettings extends Controller
{
    public function index(){
        $data['title'] = 'User Settings';
        return view('dashboard.user-settings',$data);
    }
    public function update(Request $request,$id){
        $user = User::find($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password'=>'required|confirmed|min:6'
        ]);
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
       return redirect()->back()->with('success','User Updated');
    }
}
