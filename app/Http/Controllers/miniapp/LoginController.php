<?php

namespace App\Http\Controllers\miniapp;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\User;
use Session;

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

    //判断登录状态
    public function loginAutoUser(Request $request){
        $openid = $request->input('openid'); 
        $result = User::where('open_id',$openid)->first();

        if (!empty($result)) {
            $arr = ['id'=>$result->id,'name'=>$result->nickname];
            return response()->json($arr);
        }
        return response()->json('false');
    }

    //获取Openid
    public function getOpenid(Request $request)
    {

        $appid = 'wx64f95ab001bb8dd2';
        $secret = '3fed698a0077fec6b88b4630bb73e38f';
        $grant_type = 'authorization_code';
        $js_code = $request->input('js_code');

        $post_data=array();

        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$js_code.'&grant_type='.$grant_type;
        // $url = 'http://www.caishi360.com/miniapp/list';
        $postdata = http_build_query($post_data);  
        $options = array(  
            'http' => array(  
              // 'method' => 'POST',  
              'method' => 'GET',  
              // 'header' => 'Content-type:application/x-www-form-urlencoded',
              'header' => 'Content-type:application/json',  
              'content' => $postdata,  
              'timeout' => 15 * 60 // 超时时间（单位:s）  
            )  
        );  

    $context = stream_context_create($options);  
    $result = file_get_contents($url, false, $context);  
    
    return response()->json(json_decode($result));
    }

    //获取token
    public function gettoken(Request $request){
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
        // return $request->all();
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
            $name = $request->input('name');
            $user = User::where('nickname',$name)->orWhere('email',$name)->first();
            $user->open_id = $openid;
            $user->save();

            return response()->json('true');//小程序登录返回的参数
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
        $field = filter_var($name, FILTER_VALIDATE_EMAIL) ? 'email' : 'nickname';
        return [
            $field => $name,
            'password' => $request->input('pass'),
        ];
    }

    //退出登录 （解除绑定）
    public function layout(Request $request){
        $openid = $request->input('openid');
        $user = User::where('open_id',$openid)->first();
        $user->open_id = null;
        if ($user->save()) {
            return response()->json('true');
        }
        return response()->json('false');
    }
}
