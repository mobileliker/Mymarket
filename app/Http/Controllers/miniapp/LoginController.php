<?php

namespace App\Http\Controllers\miniapp;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $username = 'login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    //获取token
    public function gettoken(){
        $token = csrf_token();
        return response()->json(['token'=>$token]);
    }
    /**
     * Process the user login.
     *
     * @param Request $request
     *
     * @return void
     */
    public function login(Request $request)
    {
        if (\Auth::user()) {
            return response()->json('true');
        }
        return $this->handle($request);
    }

    /**
     * Handle the user login.
     *
     * @param Request $request
     *
     * @return void
     */
    protected function handle(Request $request)
    {
        $this->validate($request, $this->rules());
        
        $credentials = $this->credentials($request);

        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            //获取openid
            $openid = $request->input('openid');
            $user = User::find(\Auth::user()->id);
            $user->open_id = $openid;
            $user->save();
            return response()->json('true');//小程序未登录返回的参数
        }
        // $this->incrementLoginAttempts($request);
        return response()->json('false');//小程序未登录返回的参数
    }
    
    /**
     * Return the login validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        $rules = [
            'name'    => 'required',
            'pass' => 'required',
        ];

        /*if (!env('APP_DEBUG')) {
            $rules['g-recaptcha-response'] = 'required|recaptcha';
        }*/

        return $rules;
    }

    /**
     * Return the user credentials.
     *
     * @param Request $request
     *
     * @return array
     */
    
    public function credentials(Request $request)
    {
        $name = $request->input('name');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nickname';
        return [
            $field => $name,
            'password' => $request->input('pass'),
        ];
    }

}
