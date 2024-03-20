<?php

namespace App\Http\Controllers\Auth;
use App\Managers;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Hash;
use Auth;
use Cookie;
class LoginController extends Controller
{
    protected $maxAttempts = 5; // Default is 5
    protected $decayMinutes = 60; // Default is 1
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest')->except('logout');
    }

    protected function sendFailedLoginResponse($request)
    {

        $manager = Managers::where('email', $request->email)->first() ;
        if (!$manager) {
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                   /* $this->username() => Lang::get('auth.email'),*/
                    $this->username() => "Email address not found.",
                ]);
        }


        if (!Hash::check($request->password, $manager->password)) {
            return redirect()->back()
            ->withInput($request->only($this->username(),$request->password, 'remember'))
            ->withErrors([
                /*'password' => Lang::get('auth.password'),*/
                'password' => "Wrong password provided.",
            ]);
        }
        //Cookie::forget('locale');
        //Cookie::queue('locale', "hebrew", 43800);



    }
}
