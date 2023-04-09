<?php

namespace App\Http\Controllers\Auth;

use App\Events\ConvertBasketToUser;
use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

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
    // protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectTo()
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole(['admin', 'sales_team'])) {
                return '/manage/dashboard';
            } else {
                return '/';
            }
        } else {
            return '/login';
        }
    }


    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    public function authenticated(Request $request, $user)
    {
        // Get the session ID
        $sessionId = $request->get('session_id');
        // If the session ID is not present in the request, try to get it from the cookie
        if (!$sessionId) {
            $sessionId = $request->cookie('session_id');
        }

        // Check if there is a basket with the current session ID
        $basket = Basket::where('session_id', $sessionId)->first();

        if ($basket) {
            // Fire the event to convert the basket to the user
            event(new ConvertBasketToUser( $user, $basket));
        }
        // Generate a new token for the user
        $token = $user->createToken('auth-token')->plainTextToken;


        // Continue with the default behavior
        return redirect()->intended($this->redirectPath())
        ->withCookie( Cookie::make('token', $token, 360));
    }


    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        // Continue with the default behavior
        return redirect()->intended($this->redirectPath())->withCookie(Cookie::forget('token'));
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
