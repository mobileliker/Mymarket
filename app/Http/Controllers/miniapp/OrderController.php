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

	public function payInfo(Request $request){

		$id = $request->input('id');//商品id
		$aid = $request->input('aid');//地址id
		$num = $request->input('num');//数量

		/******* Y(必填字段) *******/
		// mch_id 商户号（32）
		//appid 小程序的id（32）
		//body 商品简单描述（128）
		//nonce_str 随机字符串（32）
		//sign  签名（32）
		//out_trade_no 商户订单号(32)
		//total_fee 总金额、单位分（INT）
		//spbill_create_ip 终端ip (16)
		//notify_url 消息通知地址、不能携带参数(256)
		//trade_type 交易类型、小程序为JSAPI （16）
		//openid 用户标识、小程序必传（128）

		/******* N(可选字段) *******/
		//attach 附加信息（127）
		//device_info 终端设备号（32）
		//sign_type 签名类型、默认MD5（32）
		//detail  商品详情、json格式（6000）
		//fee_type 货币类型 默认人民币（16）
		//time_start 交易开始时间、如20091225091010（14）
		//time_expire 交易结束时间（14）
		//goods_tag 交易标记 、如代金券（32）
		//limit_pay 指定支付方式、no_credit--指定不能使用信用卡支付（32）

		$key = '18523976023wojiacaishi1436923502';//商家API密匙 

		// $appid = $request->input('appid');
		$appid = 'wx51196f271bc7480b';
		$attach = '支付测试附加信息';
		$body = '小程序支付';
		$mch_id = 1436923502;
		$nonce_str = $this->generate_string();
		$notify_url = 'http://www.caishi360.com/miniapp/list';
		// $openid = $request->input('openid');
		$openid = 'oFDbs0EpHtmUbLoqt_1HHktq0pLg';
		$out_trade_no = 'wjcs2343434';
		$spbill_create_ip = $_SERVER["REMOTE_ADDR"]; 
		$total_fee = 1;
		$trade_type = 'JSAPI';

		$stringA = "appid=".$appid."&attach=".$attach.'&body='.$body.'&mch_id='.$mch_id.'&nonce_str='.$nonce_str.'&notify_url='.$notify_url.
		'&openid='.$openid.'&out_trade_no='.$out_trade_no.'&spbill_create_ip='.$spbill_create_ip.'&total_fee='.$total_fee.'&trade_type='.$trade_type;
		$sign = strtoupper(MD5($stringA.'&key='.$key));
		
		// return $sign;

		$xml = "<xml>
		   <appid>".$appid ."</appid>
		   <attach>".$attach ."</attach>
		   <body>".$body."</body>
		   <mch_id>".$mch_id."</mch_id>
		   <nonce_str>".$nonce_str."</nonce_str>
		   <notify_url>".$notify_url."</notify_url>
		   <openid>".$openid."</openid>
		   <out_trade_no>".$out_trade_no."</out_trade_no>
		   <spbill_create_ip>".$spbill_create_ip."</spbill_create_ip>
		   <total_fee>".$total_fee."</total_fee>
		   <trade_type>".$trade_type."</trade_type>
		   <sign>".$sign."</sign>
		</xml>" ;
		// echo "<pre>";
		// var_dump($xml);die;
		// return $this->url($xml);

		return response()->json();
	}

	//随机生成32位字符串
	public function generate_string($length = 32) {  
		// 密码字符集，可任意添加你需要的字符  
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; 
	 	$string = '';  
	 	for ( $i = 0; $i < $length; $i++ )  { 
	   		// $string .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);  // 第一种是使用 substr 截取$chars中的任意一位字符； 
	 		$string .= $chars[ mt_rand(0, strlen($chars) - 1) ];  // 第二种是取字符数组 $chars 的任意元素  
	 	}  
	 	return $string;  
	} 

	public function url($xml){
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        // $xml = http_build_query($xml);  
        $options = array(  
            'http' => array(  
              'method' => 'POST',  
              // 'method' => 'GET',  
              'header' => 'Content-type:application/x-www-form-urlencoded',
              // 'header' => 'Content-type:application/json',  
              'content' => $xml,  
              'timeout' => 15 * 60 // 超时时间（单位:s）  
            )  
        );  

	    $context = stream_context_create($options);  
	    $result = file_get_contents($url);  
	    
	    return $result;
	}

	public function url2($xml){
		$second = 300;
		$url="https://api.mch.weixin.qq.com/pay/unifiedorder";
		//初始化curl        
       	$ch = curl_init();

		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$error = curl_errno($ch);
		//运行curl
        $data = curl_exec($ch);
        var_dump($data);
        // var_dump($error);
		//curl_close($ch);
		//返回结果
	}

}
