<?php

namespace app\Http\Controllers\wxapp;

/*
 * Antvel - Company CMS Controller
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\User;
use Redirect;

class UserController extends Controller
{
	public function index(){
		$user = User::find(1);
		return  response()->json($user);
	}
	public function index2(){
		$user = User::find(1);
		return  response()->json($user);
	}
}
