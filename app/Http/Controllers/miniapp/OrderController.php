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
	
	//订单查询
	public function index(Request $request){

		$user_id = \Utility::openidUser($request);
		if ($user_id == 'false') {
			return response()->json('false');
		}

		$status = !empty($request->input('status'))?$request->input('status'):'';

		$orders = Order::where('orders.user_id','=',$user_id);

		if ($status!='') {
			$orders = $orders ->where('orders.status','=',$status);
		}

		$orders = $orders->select('id','created_at','status','order_number')->get();
		$arr = array();

		if ($orders!='') {
			foreach ($orders as $k => $order) {
				$order_details = OrderDetail::where('order_details.order_id','=',$order->id)
								->join('products','order_details.product_id','=','products.id')
								->select('products.name','products.price','products.features','products.description',
									'order_details.quantity','order_details.price as detail_price')
								->get();

				$all_price = 0;		
				if ($order_details!="" && isset($order_details[0])) {
					foreach ($order_details as $key => $order_detail) {
						$order_details[$key]->image = json_decode($order_detail->features)->{'images'}[0];
						$all_price += $order_detail->price;
					}
					$arr[$k]['order'] =  $order;
					$arr[$k]['order']->allPrice = $all_price;
					$arr[$k]['products'] = $order_details;
				}
			}
		}

		return response()->json($arr);
	}

	//订单详情页
	public function order_details($id,Request $request){

		$user_id = \Utility::openidUser($request);
		if ($user_id == 'false') {
			return response()->json('false');
		}

		$address = Address::where('user_id',$user_id)->where('default',1)->first();
		$order = Order::where('orders.id','=',$id)
						->select('orders.status','orders.order_number','orders.created_at')
						->first();

		$products = OrderDetail::join('products','order_details.product_id','=','products.id')
				->where('order_id','=',$id)
				->select('order_details.product_id','products.features','products.name','products.price','order_details.id','order_details.quantity')
				->get();
		$all_price = 0;
		foreach ($products as $k=>$product) {
			$features = json_decode($product->features);
			$products[$k]->image = $features ->{'images'}[0];
			if ($features!='') {
				$str='';
				foreach ($features  as $key => $feature) {
					if ($key!='images') {
						$str= $str.$key.$feature;
					}
				}
			}
			$products[$k]->info = $str;
			$all_price += $product->price;
		}
		$order->allPrice = $all_price;

		return response()->json(['order'=>$order,'products'=>$products,'address'=>$address]);
	}

	//假设微信支付接口
	public function pay(Request $request){
		$pay = $request->input('pay');
		$paystate = 'false';

		if ($pay!='') {
			$paystate = 'true';
		}
		return response()->json($paystate);
	}

	//确认订单数据接口
	public function create(Request $request){

		$user_id = \Utility::openidUser($request);
		if ($user_id == 'false') {
			return response()->json('false');
		}

		$product_id = $request->input('product_id');//商品id
		$amount = $request->input('amount');//商品数量

		$product = Product::select('features','price','id','name')->find($product_id);

		$delivery_price = 0;//运输价格

		if ($amount!='' && $amount>1) {
			$allproductprice = $product->price * $amount;//商品总价
			$allprice = $allproductprice + $delivery_price;//最终价格（包含物流费）
			$product->allprice = $allprice;
			$product->allproductprice = $allproductprice;
		}else{
			$product->allprice = $product->price+$delivery_price;//最终价格
			$product->allproductprice = $product->price;//商品价格
		}

		$address = Address::where('user_id',$user_id)->where('default',1)->first();

		return response()->json(['product'=>$product,'address'=>$address]);
	}

	//商品生成订单
	public function store(Request $request){

		$status = 'open';//支付状态（默认未支付）

		if ($request->input('pay')=='true') {
			$status = 'paid';
		}
		$user_id = \Utility::openidUser($request);
		if ($user_id == 'false') {
			return response()->json('false');
		}

		$product_id = $request->input('product_id');//商品id
		$address_id = $request->input('address_id');//配送地址id
		$price = $request->input('price');//最终价格
		$quantity = $request->input('quantity');//数量
		$order_number = \Utility::number();//订单号
		$seller_id = Product::select('user_id')->find($product_id)->user_id;//卖家id

		$order = new Order;
		$order->type = 'order';
		$order->status = $status;
		$order->user_id = $user_id;
		$order->seller_id = $seller_id;
		$order->address_id = $address_id;
		$order->order_number = $order_number;

		//保存订单
		if ($order->save()) {
			$order_detail = new OrderDetail;
			$order_detail->order_id = $order->id;
			$order_detail->product_id = $product_id;
			$order_detail->price = $price;
			$order_detail->quantity = $quantity;
			$order_detail->quantity = $quantity;
			//保存订单详情
			if ($order_detail->save()) {
				return  response()->json($order_detail->id);
			}
		}
			return response()->json('false');
	}

	//修改订单状态
	public function update(Request $request){
		$id = $request->input('orderid');
		$status = $request->input('status');
		$arr = ['open','cancelled','close','pending','paid','sent','received'];
		if (in_array($status,$arr)) {
			$order = Order::find($id);
			$order->status = $status;
			$order->save();
			return response()->json('true');
		}
		return response()->json('false');
	}

	//删除单个订单
	public function destory($id){
		$order = Order::find($id);
		if ($order->destory()) {
			return response()->json('true');
		}
		return response()->json('false');
	}
}
