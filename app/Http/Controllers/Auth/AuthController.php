<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use App\ConstsAndFuncs;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Socialite;
use Auth;
use Illuminate\Http\Request;

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

    protected $redirectPath = '/';

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
            'expire_at' => 'max:255',
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
        $token = null;
		if (array_key_exists('Type', $data))
			$Type = $data['Type'];
        if (array_key_exists('token', $data))
            $token = $data['token'];
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'token' => $token,
			'Type' =>  $Type,
            'expire_at' => new \DateTime()
        ]);
    }

    public static function checkPermission(){
        if ((!auth()->user()) || (auth()->user()->admin < ConstsAndFuncs::PERM_ADMIN)) {
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
        $data = ['name' => $user->name, 'email' => $user->email, 'password' => $user->token, 'token' => $user->token, 'Type' => 2];
//        dd($data);
        if ($user->email == null){
            $data['email'] = $user->id . "@facebook.com";
        }
//        dd($data);
        $userDB = User::where('email', 'LIKE', $data['email'])->first();
        if (!is_null($userDB)){
            $userDB->token = $data['token'];
            $userDB->update();
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
        $data = ['name' => $user->name, 'email' => $user->email, 'password' => $user->token, 'token' => $user->token, 'Type' => 3];
//        dd($data);
        if ($user->email == null){
            $data['email'] = $user->id . "@gmail.com";
        }
		if ($user->name == null){
			$data['name'] = $data['email'];
		}
//        dd($data);
        $userDB = User::where('email', 'LIKE', $data['email'])->first();
        if (!is_null($userDB)){
            $userDB->token = $data['token'];
            $userDB->update();
            Auth::login($userDB);
        }
        else{
            Auth::login($this->create($data));
        }
        return redirect('/');
    }

    // override postLogin in AuthenticatesUsers.php to redirect User to previous post after logging in.
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required', 'redirectPath' => 'max:255'
        ]);

        if ($request->redirectPath != null){
            $this->redirectPath = $request->redirectPath;;
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

}
