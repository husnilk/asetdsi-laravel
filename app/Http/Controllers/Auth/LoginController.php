<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    // public function login(Request $request)
    // {
    //     $this->validateLogin($request);
    //     dd($request->all());
    // }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
   

    public function username()
    {
        return 'username';
    }


    // public function showLoginForm()
    // {
    //     return view('auth.login');
    // }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    // protected function guard()
    // {
    //     return Auth::guard('auth');
    // }

    // protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->redirectTo = route('indexs');
        // $this->middleware('auth');
        $this->middleware('guest')->except('logout');
    }
}
