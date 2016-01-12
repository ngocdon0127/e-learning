<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Socialite;
use Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'Type' => 'max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
		$Type = 1;
		if (array_key_exists('Type', $data))
			$Type = $data['Type'];
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
			'Type' =>  $Type,
        ]);
    }

    public static function checkPermission(){
        if ((!auth()->user()) || (auth()->user()->admin != 1)) {
            return false;
        }
        return true;
    }

    public function redirectToProvider(){
        return Socialite::driver('facebook')->redirect();
    }

    public function googleRedirectToProvider(){
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback(){
        $user = Socialite::driver('facebook')->user();
        $data = ['name' => $user->name, 'email' => $user->email, 'password' => $user->token, 'Type' => 2];
//        dd($data);
        if ($user->email == null){
            $data['email'] = $user->id . "@facebook.com";
        }
//        dd($data);
        $userDB = User::where('email', 'LIKE', $user->email)->first();
        if (!is_null($userDB)){
            Auth::login($userDB);
        }
        else{
            Auth::login($this->create($data));
        }
        return redirect('/');
    }

    public function googleHandleProviderCallback(){
        $user = Socialite::driver('google')->user();
//        dd($user);
        $data = ['name' => $user->name, 'email' => $user->email, 'password' => $user->token, 'Type' => 3];
//        dd($data);
        if ($user->email == null){
            $data['email'] = $user->id . "@gmail.com";
        }
		if ($user->name == null){
			$data['name'] = $data['email'];
		}
//        dd($data);
        $userDB = User::where('email', 'LIKE', $user->email)->first();
        if (!is_null($userDB)){
            Auth::login($userDB);
        }
        else{
            Auth::login($this->create($data));
        }
        return redirect('/');
    }

    public function soundCloudHandleCallback(){
        return '3';
    }
}
