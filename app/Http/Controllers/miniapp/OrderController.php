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
class OrderController extends Controller
{	
	
	//假设微信支付接口
	public function pay(Request $request){
		$pay = $request->input('pay');
		$paystate = 'false';

		if ($pay!='') {
			$paystate = 'true';
		}
		return $paystate;
	}

	//商品生成订单
	public function order(Request $request){

		$status = 'open';//支付状态（默认未支付）

		if ($this->pay()=='true') {
			$status = 'paid';
		}

		$user_id = \Auth::user()->id;//买家id
		$product_id = $request->input('product_id');//商品id
		$address_id = $request->input('address_id');//配送地址id
		$price = $request->input('price');//最终价格
		$quantity = $request->input('quantity');//数量
		$order_number = \Utility::number();//订单号

		// $product_id = 5;

		$seller_id = Product::select('user_id')->find($product_id)->user_id;
		$order = new Order;
		$order->type = 'order';
		$order->status = $status;
		$order->user_id = $user_id;
		$order->seller_id = $seller_id;
		$order->address_id = $address_id;
		$order->order_number = $order_number;

		if ($order->save()) {
			$order_detail = new OrderDetail;
			$order_detail->order_id = $order->id;
			$order_detail->product_id = $product_id;
			$order_detail->price = $price;
			$order_detail->quantity = $quantity;
			$order_detail->quantity = $quantity;
			if ($order_detail->save()) {
				return $order_detail->id;
			}
			return 'false';
		}
		return 'false';
	}

}
