<?php

namespace app\Http\Controllers\miniapp;

/*
 * Antvel - Company CMS Controller
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\User;
use App\Product;
use Redirect;

//小程序首页数据
class HomeController extends Controller
{	

	public function index(){
		// \Auth::loginUsingId(1);
		$product = Product::where('status','=',1)
				->where('condition','=','new')
				->orderBy('created_at','desc')
				->select('id','name','features','price','description')
				->limit(10)
				->distinct()
				->get();
		return  response()->json($product);
	}
}
