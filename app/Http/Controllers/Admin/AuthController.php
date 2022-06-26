<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session,Auth;

class AuthController extends Controller
{
    public function login(){
        return view('admin.auth.login');
    }

    function login_attempt(Request $request){

        $this->validate($request,[
            'email' => 'required',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            return redirect()->intended('/admin/dashboard');
        }else{
            return redirect()->back()->with('error', 'Invalid credentials!');
        }

    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('admin:login');
    }
}
