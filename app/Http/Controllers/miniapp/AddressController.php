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
use App\OrderDetail;
use App\Order;
use DB;
use Illuminate\Http\Request;
use App\Product;
use App\Address;
use Redirect;



//商品数据
class AddressController extends Controller
{	
	//修改默认地址
	public function default($id){
		$user_id = \Auth::user()->id;
		$user_id = 2;

		$addressAll = Address::where('user_id',$user_id)->where('default',1)->first();
		if (!empty($addressAll)) {
			$addressAll->default = 0;
			$addressAll->save();
		}

		$address = Address::find($id);
		$address->default = 1;
		$address->save();
		
	}

	public function index(){
		$user_id = \Auth::user()->id;
		if ($user_id!='') {
			$address = Address::where('user_id',$user_id)->get();

		}else{
			return 'false';
		}
	}

}
