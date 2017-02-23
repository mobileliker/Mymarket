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
class ProductController extends Controller
{	
	//列表页数据
	public function index(Request $request){

		$orderName = 'products.product_rate';
		$order = 'desc';

		$field = '';
		$field = !empty($request->input('field'))?$request->input('field'):$field;
		$text = !empty($request->input('text'))?$request->input('text'):'';
		$order = !empty($request->input('order'))?$request->input('order'):$order;
		$start_price = !empty($request->input('start_price'))?$request->input('start_price'):'';
		$brand = !empty($request->input('brand'))?$request->input('brand'):'';
		$end_price = !empty($request->input('end_price'))?$request->input('end_price'):'';


		$products = Product::where('products.status','=',1)
			->leftJoin('order_details',function($join){
				$join->on('products.id','=','order_details.product_id')->whereNotNull('order_details.rate');
			});


		if ($field=='sell') {
			$orderName = 'num';
		}

		if ($field=='price') {
			$orderName = 'products.price';
		}

		if ($text!='') {
			$products = $products->where('products.name','like','%'.$text.'%');
		}
		if ($start_price!='') {
			$products = $products->where('products.price','>=',$start_price);
		}
		if ($end_price!='') {
			$products = $products->where('products.price','<=',$end_price);
		}
		if ($brand!='') {
			$products = $products->where('products.brand','=',$brand);
		}
		$products = $products->select('order_details.id as did','products.*',DB::raw("count('order_details.id') as num"))
				->orderBy($orderName,$order)
                ->groupBy('products.id')
				->paginate(10);
		$products->appends(['field'=>$field,
										'text'=>$text,'order'=>$order,'brand'=>$brand,'start_price'=>$start_price,'end_price'=>$end_price])
										->links();
		return  response()->json($products);
	}

	//商品详情页数据
	public function product($id){

		$product = Product::find($id);
		$category = Product::where('category_id',$product->category_id)->select('id','features')->get();
		$comments = OrderDetail::join('orders','order_details.order_id','=','orders.id')
					->join('users','orders.user_id','=','users.id')
					->where('order_details.product_id','=',$id)
					->orderBy('order_details.created_at','desc')
					->select('order_details.*','users.nickname as user_name');
		$ratecount = count($comments->get());//评论总数
		$commentfirst = $comments->first();//第一条最新评论
		$goodrate = ($product->product_rate*10).'%';//好评率		

		$pre = '/<img.*?src="(.*?)".*?>/';
		preg_match_all($pre,$product->desc_img,$arr);

		$details['product'] = $product;//商品详情
		$details['category'] = $category;//规格
		$details['ratecount'] = $ratecount;//评论总数
		$details['commentfirst'] = $commentfirst;//第一条最新评论
		$details['commentfirstimgs'] = '';
		if (!empty($commentfirst)) {
			$details['commentfirstimgs'] = explode(',',$commentfirst->image);//第一条最新评论
		}
		$details['goodrate'] = $goodrate;//好评率
		$details['desc_img'] = $arr[1];//商品大图详情

		return  response()->json($details);
	}

	//商品评价详情页数据
	public function comment(Request $request,$id){

		$good = !empty($request->input('good'))?$request->input('good'):'';
		$common = !empty($request->input('common'))?$request->input('common'):'';
		$bad = !empty($request->input('bad'))?$request->input('bad'):'';
		$image = !empty($request->input('image'))?$request->input('image'):'';

		$comments = OrderDetail::join('orders','order_details.order_id','=','orders.id')
					->join('users','orders.user_id','=','users.id')
					->where('order_details.product_id','=',$id)
					->whereNotNull('order_details.rate_comment')
					->orderBy('order_details.created_at','desc')
					->select('order_details.*','users.nickname as user_name');
	
		if ($good!='') {
			$comments = $comments->where('order_details.rate','>',6);
		}
		if ($common!='') {
			$comments = $comments->where('order_details.rate','=',6);
		}
		if ($bad!='') {
			$comments = $comments->where('order_details.rate','<',6);
		}
		if ($image!='') {
			$comments = $comments->whereNotNull('order_details.image');
		}
		$comments = $comments->get();//评论内容

		//获取各类数量
		$rategood = OrderDetail::where('order_details.product_id','=',$id)
					->whereNotNull('order_details.rate_comment')
					->where('order_details.rate','>',6)
					->count();//好评总数
		$ratecommon = OrderDetail::where('order_details.product_id','=',$id)
					->whereNotNull('order_details.rate_comment')
					->where('order_details.rate','=',6)
					->count();//中评总数
		$ratebad = OrderDetail::where('order_details.product_id','=',$id)
					->whereNotNull('order_details.rate_comment')
					->where('order_details.rate','<',6)
					->count();//差评总数
		$rateimage = OrderDetail::where('order_details.product_id','=',$id)
					->whereNotNull('order_details.rate_comment')
					->whereNotNull('order_details.image')
					->count();//带图评总数
		$ratecount = OrderDetail::where('order_details.product_id','=',$id)
					->whereNotNull('order_details.rate_comment')
					->count();//评论总数

		$details['comments'] = $comments;//所有评论
		$details['ratecount'] = $ratecount;//评论总数
		$details['rategood'] = $rategood;//好评数
		$details['ratecommon'] = $ratecommon;//中评数
		$details['ratebad'] = $ratebad;//差评数
		$details['rateimage'] = $rateimage;//带图评论数

		return  response()->json($details);
	}

}
