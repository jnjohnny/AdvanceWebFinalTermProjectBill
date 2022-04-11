<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\login;
use App\Models\registration;

class LoginController extends Controller
{
    //
    public function Login_view(Request $req)
    {
        return view('Nabil.login');
    }
    public function Login(Request $req)
    {
        $user = login::where('username','=',$req->username)
        ->where('password','=',md5($req->password))
        ->first();
        $reg = registration::where('username','=',$req->username)->first();

        if($user!=null)
        {
            if($user->is_verified == 0)
            {
                $req->session()->flash('failed_msg','Verfication Link has been sent to your email. Please verify');
                return redirect()->back()->with(session()->flash('alert-success', 'Account has been create. Please check email for verification mail'));
            }
            else
            {
                $req->session()->put('user',$req->username);
                $req->session()->flash('msg','Login Successful');
                return redirect('/');
            }


        }
        else
        {
            $req->session()->flash('failed_msg','Incorrect Credentials');
            return redirect(route('user.login'));
        }
    }

    public function Logout()
    {
        session()->flush();
        return redirect(route('user.login'));
    }

    public function forgotpass()
    {
        return view('Nabil.forgotpass');
    }

    public function forgotpassSubmit(Request $req)
    {
        $user = registration::where('email','=',$req->email)->first();
        MailController::sendForgotPassEmail($user->name, $user->email, md5($req->password) );
        $req->session()->flash('msg','Password sent to your email');
        return view('Nabil.forgotpass');
    }

    public function ResetPass(Request $req)
    {
        $reg = registration::where('email','=',$req->email)->first();
        $user = login::where('username','=',$reg->username)->first();
 
        $reg->password = $req->code;
        $reg->save();

        $user->password = $req->code;
        $user->save();

        $req->session()->flash('msg','Password has been reset');
        return redirect(route('user.login') );
    }
    
    public function verifycred(Request $req)
    {
        $user = login::where('verification_code','=',$req->code)->first();

        if($user!=null)
        {
            if($user->is_verified==0)
            {
                $user->is_verified = 1;
                $user->save();
                $req->session()->flash('msg','Verified Successfully');
            }
            else
            {
                $req->session()->flash('msg','Already Verified');
            }
            return redirect(route('user.login'));
        }
        else
        {
            $req->session()->flash('err_msg','Invalid verification link');
            return redirect(route('user.login'));
        }
        
    }
}
