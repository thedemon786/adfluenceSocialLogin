<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

    //facebook controllers
    public function redirectToFacebookProvider()
   {
    return Socialite::driver('facebook')->redirect();
}
 
/**
 * Obtain the user information from Facebook.
 *
 * @return void
 */
 public function handleProviderFacebookCallback()
{
    $auth_user = Socialite::driver('facebook')->user();
 
    $user = User::updateOrCreate(
        [
            'email' => $auth_user->email
        ],
        [
            'token' => $auth_user->token,
            'name'  =>  $auth_user->name
        ]
    );
 
    Auth::login($user, true);
    return redirect()->to('/'); // Redirect to a secure page
}
}
