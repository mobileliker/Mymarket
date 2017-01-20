@extends('szy.auth.log_reg')

@section('title')
用户注册 
@stop

@section('content')
	<form action="/register" class='form-horizontal' method="POST">
		{{ csrf_field() }}

	<li class="border">欢迎注册<div>已注册<a href="login">可直接登录</a></div></li>
        <li><div class="user-s"><div></div></div><input class="user-i" type="text" name="nickname"  placeholder=" 请输入用户名">
        @if ($errors->has('nickname'))
            <span style="position: absolute;top:75px;left:340px;width:300px;color:red"><strong>{{ $errors->first('nickname') }}</strong></span>
        @endif
        </li>
	<li><div class="user-s"><div></div></div><input class="user-i" type="text" name="email"  placeholder=" 请输入邮箱"></li>
        @if ($errors->has('email'))
            <span style="position: absolute;top:125px;left:340px;width:300px;color:red"><strong>{{ $errors->first('email') }}</strong></span>
        @endif
	<li><div class="pass-s"><div></div></div><input class="pass-i" type="password" name="password"  placeholder=" 建议两种字符结合"></li>
         @if ($errors->has('password'))
            <span style="position: absolute;top:175px;left:340px;width:300px;color:red"><strong>{{ $errors->first('password') }}</strong></span>
        @endif
	<li><div class="pass-s"><div></div></div><input class="pass-i" type="password" name="password_confirmation"  placeholder=" 请再次输入密码"></li>
         @if ($errors->has('password_again'))
            <span style="position: absolute;top:225px;left:340px;width:300px;color:red"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
        @endif
	<li><button class="submit">立即注册</button></li>
	</form>
@stop
 {{-- end content --}}
