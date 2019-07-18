<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;
class CustomLoginController extends Controller
{
    function index()
    {
        return view('login');
    }

    function checklogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password'  => 'required|alphaNum|min:3'
        ]);

        $user_data = array(
            'email'  => $request->get('email'),
            'password' => $request->get('password')
        );

        $user=$user_data['email'];
        $activeUser=DB::table('users')->where('email',$user)->value('email');
        $loginattempts=DB::table('users')->where('email',$user)->value('loginAttempt');
        if($loginattempts>0)
        {
            if(Auth::attempt($user_data))
            {
                DB::table('users')->where('email',$activeUser)->update(['loginAttempt'=>3]);
                return redirect('/tasks');
            }
            else
            {
                DB::table('users')->where('email',$activeUser)->decrement('loginAttempt');
                $loginattempts=DB::table('users')->where('email',$user)->value('loginAttempt');
                return back()->with('error', 'Invalid Credentials. Please try again.')
                                ->with('loginAttempt',$loginattempts);

            }
        }
        else
        {
            return back()->with('error', 'You cannot login. Too many attempts.');
        }


    }

    function successlogin()
    {
        return view('tasks.index');
    }

    function logout()
    {
        Auth::logout();
        return redirect('auth.login');
    }
}
