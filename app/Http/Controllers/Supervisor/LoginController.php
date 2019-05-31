<?php

namespace App\Http\Controllers\Supervisor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Symfony\Component\HttpFoundation\Session\Session;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/supervisor';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:supervisor')->except('logout');
    }

    public function showLoginForm()
    {
        return view('supervisor.login');
    }

    protected function guard()
    {
        return Auth::guard('supervisor');
    }

    public function showLinkRequestForm()
    {
        return view('supervisor.passwords.email');
    }

    public function logout(Request $request)
    {
        // Session::flush();
        $this->guard('supervisor')->logout();

        $request->session()->invalidate(true);

        return redirect('/supervisor-login');
    }
}
