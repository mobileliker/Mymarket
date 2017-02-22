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
		if ($address->save()) {
			return response()->json('true');
		}
		return response()->json('false');
	}

	//查询地址
	public function index(){

		$user_id = \Auth::user()->id;

		if ($user_id!='') {
			$address = Address::where('user_id',$user_id)->get();
			return response()->json($address);
		}else{
			return response()->json('false');
		}
	}

	//加载修改的地址
	public function edit($id){

		$address = Address::find($id);
		return response()->json($address);
	}

	//保存地址
	public function store(Request $request){

		return $this->storeOrUpdate($request);
	}

	//保存修改
	public function update(Request $request,$id){

		return $this->storeOrUpdate($request,$id);
	}

	//修改新建保存方法
	public function storeOrUpdate($request,$id=-1){

		$city = $request->input('city');
		$name = $request->input('name');
		$phone = $request->input('phone');
		$state = $request->input('state');
		$line1 = $request->input('line1');

		if ($id>-1) {
			$address = new Address;
		}else{
			$user_id = \Auth::user()->id;
			$address = Address::find($user_id);
		}

		$address->city = $city;
		$address->name = $name;
		$address->default = 0;
		$address->phone = $phone;
		$address->state = $state;
		$address->line1 = $line1;

		if ($address->save()) {
			return response()->json('true');
		}
		return response()->json('false');
	}

	//删除单个地址接口
	public function destroy($id){

		$address = Address::find($id);
		if ($address->destroy()) {
			return response()->json('true');
		}
		return response()->json('false');
	}
}
 