<?php

namespace App\Http\Controllers\Auth;

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
            return 'true';
        }

        if ($request->input('newuser')) {
            session()->flash('email', $request->input('email'));

            return redirect('/register');
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
        $wx = !empty($_POST['wx'])?$_POST['wx']:'';//是否为微信小程序传参数过来

        if ($this->guard()->attempt($credentials, $request->has('remember'))) {

            return redirect($this->redirectTo);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }
    
    //登录失败提示
    public function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => Lang::get('用户名或密码错误'),
            ]);
    }
    
    //获取登录字段
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }

    /**
     * Return the login validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        $rules = [
            'login'    => 'required',
            'password' => 'required',
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
        $login = $request->get('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nickname';
        return [
            $field => $login,
            'password' => $request->get('password'),
        ];
    }

    /**
     * Returns the login message error.
     *
     * @return string
     */
    public function getFailedLoginMessage()
    {
        return trans('user.credentials_do_not_match_our_records');
    }
    public function showLoginForm(){
        return view('szy.auth.login');
    } 
}
