<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\User;

use Illuminate\Support\Facades\Session ;

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

    public function login(Request $request){

        $validated = $request->validate([
            'office_id' => 'required',
            'password' => 'required',
        ]);
        

        if(auth()->attempt(array('office_id'=>$request->office_id,'password'=>$request->password))){
            
            if(Auth::user()->status == 0){
                Auth()->logout();
                return redirect('/login')->withInput()->withErrors('Your access is disabled! Please contact your system admin.');
            }

            if(auth()->user()->status==1){
                Session::put('last_active_time',time());
                return redirect('/home');
            }

        }
        else
        {
            return redirect('/login')->withInput()->withErrors('These credentials do not match our records');

        }
    }
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'user_name';
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        \App\Library\AuditTrailLib::addTrail('Login','Unknown','Inputed user id :'.$request->user_name.' password : '.$request->password,'Failed');
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    protected function authenticated(Request $request, User $user){
        //put your thing in here
        \App\Library\AuditTrailLib::addTrail('Login',Auth::user()->user_name,'Login successfully','success');
        /**
         * Check user Status is active or not
         */
      
        if(Auth::user()->status == 0){
            Auth()->logout();
            return redirect('/login')->withInput()->withErrors('Your access is disabled! Please contact your system admin.');
        }

        return redirect()->intended($this->redirectPath());
    }

    public function logout(Request $request)
    {
        $user_name = Auth::user()->user_name;
        $this->guard()->logout();
        \App\Library\AuditTrailLib::addTrail('Logout',$user_name,'Logout successfully','success');
        $request->session()->invalidate();
        return redirect('/');
    }
}
