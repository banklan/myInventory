<?php

namespace App\Http\Controllers\Auth;

use App\UserBatch;
use App\UserLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    function authenticated(\Illuminate\Http\Request $request)
    {
        $me = Auth::id();
        //check if ive logged into the app before
        $logins = UserLogin::where('user_id', $me)->first();
        if($logins){
            $logins->update([
                $logins->last_login = Carbon::now()->toDateTimeString(),
                $logins->ip = $_SERVER['REMOTE_ADDR'],
            ]);
        }else{
            $newLogin = new UserLogin;
            $newLogin->user_id = Auth::id();
            $newLogin->role_id = 1;
            $newLogin->last_login = Carbon::now()->toDateTimeString();
            $newLogin->ip = $_SERVER['REMOTE_ADDR']; //or $request->ip()

            $newLogin->save();
        }
    }

    
}
