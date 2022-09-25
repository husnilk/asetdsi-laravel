<?php

namespace App\Http\Controllers\Pj;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class LoginPjController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
    {
        $this->middleware('auth:pj',  ['except'=>['logout']]);
    }

    protected $redirectTo = '/pj-aset';
    // protected $redirectPath = '/pj-aset';
    public function username()
    {
        return 'username';
    }

    // public function getAuthIdentifierName() {
    //     return 'pic_id';
    // }

    // protected $redirectTo = '/';
    public function showLoginForm()
    {
        return view('pages.pj-aset.login');
    }


    protected function guard()
    {
        return Auth::guard('pj');
    }
}
