<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Managers;
use Auth;
use Hash;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    public function changePassword(Request $request)
    {
        if($request->isMethod('post'))
        {
            $request->validate([
            
                'current_password' => 'required',
                'new_password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-7])(?=.*?[#?!@$%^&*-]).{6,}$/',
                'confirm_new_password' => 'required|same:new_password'
            ],
            [
                'new_password.regex'=>'Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.',
                'confirm_new_password.same' => 'Confirm Password  should match the Password'
            ]);
            
            if (!Hash::check($request->current_password,Auth::user()->password)) 
            {
                return redirect()->back()
                ->withInput($request->only($request->current_password,$request->new_password,$request->confirm_new_password))
                ->withErrors([
                    
                    'current_password' => "Wrong password provided.",
                ]);
            }
            else
            {
                $manager =Managers::find(Auth::user()->id);
                $manager->password=Hash::make($request->new_password);
                if($manager->save())
                {
                    \Session::flash('change', 'Successfully Change Your Password');
                    \Session::flash('class', 'success');
                    return redirect()->route('dashboardListing');  
                }
                else{
                    \Session::flash('change', 'Unsuccessfully Change Your Password');
                    \Session::flash('class', 'danger');
                    return redirect()->route('dashboardListing'); 
                }
                
            }
            
        }
        else
        {
            $data['page_title']='Change Password';
            $data['link']='Change Password';
            return view('auth/passwords/change',$data);
        }
        
    }
}
