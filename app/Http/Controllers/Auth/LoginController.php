<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


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
        $this->middleware('auth')->only('logout');
    }

    // +++++++++++++++++++++++++++++++++++++=
    // هذا اوفر رايت على تابع الاوثنتكيت   فيتؤيت الاوثنتكيت لاعادة التوجيه 
    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('super-admin') || $user->hasRole('admin')) {
            return redirect()->route('/dashboard');   // توجيه الـ admin و super-admin
        } elseif ($user->hasRole('user')) {
            return redirect()->route('landing-page');    // توجيه الـ user
        }

        return redirect('/');  // توجيه افتراضي في حال لم يكن لديه أي دور
    }
    // +++++++++++++++++++++++++++++++++++++++++
}
