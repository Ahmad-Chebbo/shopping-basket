<?php

namespace App\Http\Controllers\Auth;

use App\Events\ConvertBasketToUser;
use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }


    protected function registered(Request $request, $user)
    {
        // Get the session ID
        $sessionId = $request->get('session_id');

        // Check if there is a basket with the current session ID
        $basket = Basket::where('session_id', $sessionId)->first();
        // If the session ID is not present in the request, try to get it from the cookie
        if (!$sessionId) {
            $sessionId = $request->cookie('session_id');
        }

        if ($basket) {
            // Fire the event to convert the basket to the user
            event(new ConvertBasketToUser( $user, $basket));
        }

        // Continue with the default behavior
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->addRole('user');
        return $user;
    }
}
