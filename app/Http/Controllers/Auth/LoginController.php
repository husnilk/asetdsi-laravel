<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
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

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $attemp = Auth::guard()->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
        if (!$attemp) {
            $attemp = Auth::guard('pj')->attempt(
                $this->credentials($request), $request->boolean('remember')
            );
        }

        if ($attemp) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }
            // $isAuthenticatedAdmin = (Auth::guard('pj'));
            // dd($isAuthenticatedAdmin);
            

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        if (Auth::guard()->check()) {
            Auth::guard()->logout();
        }

        if (Auth::guard('pj')->check()) {
            Auth::guard('pj')->logout();
        }
      

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
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
        $this->middleware('guest:pj')->except('logout');
    }
}
