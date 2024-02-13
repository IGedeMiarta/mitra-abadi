<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(){
        return view('home.login');
    }
    public function register(){
        return view('home.register');
    }
    public function forgot(){
        return view('home.forgot');
    }
    public function otp(){
        return view('home.otp');

    }
    public function resetPass(){
        return view('home.reset');
    }
    public function resetPassPost(Request $request){
        $request->validate([
             'email' => 'required|email',
             'password' => 'required|confirmed|min:6',
        ]);
        $user = User::where('email',$request->email)->first();
        $user->password = Hash::make($request->password);
        $user->otp = null;
        $user->save();
        Session::flush();
        return redirect()->intended('/login')->with('success','Reset Password Success');

    }
    public function registered(Request $request){
       $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'email|unique:users',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        DB::beginTransaction();
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'password'=> Hash::make($request->password)
            ]);
            DB::commit();
            return redirect()->intended('/')->with('success','Register Success');
        } catch (\Throwable $th) {
           DB::rollBack();
           dd($th->getMessage());
        }
    }
    public function authecicate(Request $request){
       
        $credentials = $request->validate([
            'type' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('email',$request->type)->orWhere('phone',$request->type)->first();
        if ($user && Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            if($user->role == 'cust'){
                return redirect()->intended('/')->with('success','Welcome Back </br>'. $user->name );
            }elseif($user->role == 'admin'){
                return redirect()->intended('/admin/dashboard')->with('success','Welcome Back </br>'. $user->name );
            }else{
                return redirect()->intended('/lead/dashboard')->with('success','Welcome Back </br>'. $user->name );
            }
 
        }
 
        return back()->withErrors([
            'type' => 'The provided credentials do not match our records.',
        ])->onlyInput('type');
    }
    public function logout(Request $request){
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/')->with('success','Logout Success');
    }

    public function forgotPost(Request $request){
        $request->validate([
            'type' => 'required'
        ]);
        $user = User::where('email',$request->type)->orWhere('phone',$request->type)->first();
        if($request->phone){
            $otp = mt_rand(100000, 999999);
            $user->otp = $otp;
            $user->save();
            $message = '*'.$otp .'* adalah kode verifikasi Anda, valid selama 5 menit. Agar akun Anda tetap aman, jangan pernah teruskan kode ini.';
            sendWA($message,$user->phone);
            return redirect()->intended('/otp')->with('success','OTP code send, Check WhatsApp');
        }
        if($user){
            Session::put('type',$request->type);
            Session::put('user', $user);
            return redirect()->back()->with('success','User Found');
        }else{
            return redirect()->back()->with('error','User Not Found');
        }
       
    }
    public function checkOTP(Request $request){
       
        $user = User::where(['phone'=>$request->phone,'otp'=>$request->otp])->first();
        if(!$user){
            return redirect()->back()->withErrors(['otp' => 'Invalid OTP Code']);
        }
        return redirect()->route('reset')->with('success','Now You Can Reset Password');
    }   
}
