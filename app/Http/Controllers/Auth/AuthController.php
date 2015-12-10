<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends Controller
{
    use ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }
    
    /**
     * Log the user in with the credentials send in the POST request
     *
     * @param \Illuminate\Http\Request $request
     *
     * return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required', 'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        // check if login is succesfull
        if (Auth::attempt($credentials, $request->has('remember')))
        {
            // flash message to session
            $request->session()->flash('info', trans('auth.flash.loggedin'));
        
            return back();
        }
        
        // show error message through flash message
        $request->session()->flash('error', trans('auth.flash.loginfailed'));
        
        return redirect()->back()
            ->withInput($request->only('username', 'remember'));
    }
    
    /**
     * Logout current user
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout(Request $request)
    {
        // logout user
        Auth::logout();
        
        // flash message to session
        $request->session()->flash('info', trans('auth.flash.loggedout'));
        
        return redirect()->back();
    }
}
