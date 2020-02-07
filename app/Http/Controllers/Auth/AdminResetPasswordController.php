<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
/*
|----------------------------------------------------
| Addition
|----------------------------------------------------
*/
use Password; //facade
use Auth;
use Illuminate\Http\Request;

class AdminResetPasswordController extends Controller
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
    protected $redirectTo = RouteServiceProvider::ADMIN_HOME;

    /*
    |--------------------------------------------------------------------------
    | 要加，不然登入後按reset password button還是會跳到修改密碼的地方
    |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }
    
    

    /*
    |--------------------------------------------------------------------------
    | override ResetsPasswords function
    |--------------------------------------------------------------------------
    */
    // 指明登入後是哪個身分guard
    protected function guard()
    {
        return Auth::guard('admin');
    }

    // 指定使用哪個password broker
    protected function broker()
    {
        return Password::broker('admins');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset-admin')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
