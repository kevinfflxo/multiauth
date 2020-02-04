<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Auth;

class AdminLoginController extends Controller
{		
	public function __construct() {
		$this->middleware('guest:admin')->except('logout');
	}

    public function showLoginView() {
		return view('auth.admin-login');
    }

    public function login(Request $request) {
    	// Validate the form data
    	$request->validate([
		    'email' => 'required|email',
		    'password' => 'required|min:6'
		]);

    	// Attempt to Log the user in
    		// $credentials:match up to model
    		// attemp():會自動加密，因此不需要手動將password加密
    	if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
    		// if successful, then redirect to their intended location
    		return redirect()->intended(route('admin.dashboard'));
    		// return redirect()->route('admin.dashboard');
    	}
    	
    	// if unsuccessful, then redirect back to the login with the form data
		return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout() {
        Auth::guard('admin')->logout();
        /*
        |----------------------------------------------------------
        | 如果不註解掉，則user的session也會被清掉，則user也會跟著登出
        |----------------------------------------------------------
        |$request->session()->invalidate();
        |
        |$request->session()->regenerateToken();
        |----------------------------------------------------------
        */
        return redirect('/');
    }
}
