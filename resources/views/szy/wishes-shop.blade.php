@extends('szy.layouts.wishes-app')

@section('title')
	我家菜市 - 关注的店铺
@stop


@section('css')
	{!! Html::style('/css/szy/wishes-shop.css') !!}
@stop

@section('content')
	<div class="attent-list">
		{{--
		<div class="th-chk">
			<div class="select">
				<input type="checkbox" name="select_all" value="true">
				<span>全选</span>

			</div>
			<div class="operate">
				<ul>
					<li><a href="">加入购物车</a></li>
					<li><a href="">取消关注</a></li>
				</ul>
			</div>
			<div class="pages">
				<em>1</em>
				<span>/2</span>
				<button class="prev"></button>
				<button class="pages-next">下一页</button>
			</div>
		</div>--}}
		@if(!empty($businessCount))
			@foreach($businessCount as $bus)
			<div class="tr-shop">
				{{--<div class="check"><input type="checkbox" ></div>--}}
				<div class="shop-detail">
					<a href=""><img src="{{$bus->logo}}" alt=""></a>
					<h2><a href="">{{$bus->business_name}}</a></h2>
					<div class="attent-moods">
						<span>关注人气：</span>
						<span class="sum"><?php echo DB::table('user_business')->where('user_business.business_id','=',$bus->user_id)->count(); ?></span>
						<span>人</span>
					</div>
					<div class="attent-time">
						<span>关注时间</span>
						<span> {{ date('Y-m-d', strtotime($bus->created_at)) }}</span>
					</div>
					<a href="shop/{{$bus->user_id}}"><button class="enter-shop">进入店铺</button></a>
					{{--<button class="touch-service">联系客服</button>--}}
       
					<a href=""><button class="cancel-attent">取消关注</button></a>
				</div>
				<div class="shop-right">

					<?php 
						$products = App\Product::where('user_id',$bus->user_id)->select('features','id','price','name')->limit(5)->get();
					?>
					@if(!empty($products))
						@foreach($products as $product)
						<li>
							<div class="img-p">
							<a href="products/{{$product->id}}"><img src="{{$product->features['images'][0]}}" title="{{$product->name}}"></a>
							</div>
							<div class="price-p">￥{{$product->price}}</div>
						</li>
						@endforeach
					@endif
				</div>
			</div>
			@endforeach
		@endif

		<div class="table-foot">
			{{--
			<div class="select">
				<input type="checkbox" name="select_all" value="true">
				<span>全选</span>
			</div>
			<div class="operate">
				<ul>
					<li><a href="">加入购物车</a></li>
					<li><a href="">取消关注</a></li>
				</ul>
			</div>
			<div class="pages">
				<ul class="items">
					<li class="item_prev">
						<a href="#">
							<span class="icons"></span>
							<span class="prev">上一页</span>
						</a>
					</li>
					<li class="item"><span class="num">1</span></li>
					<li class="item"><a href="#">2</a></li>
					<li class="item_next">
						<a href="">
							<span class="next">下一页</span>
							<span class="icons"></span>
						</a>
					</li>
				</ul>
				<div class="total_page">共2页</div>
				<div class="form">
					<span class="text">到第</span>
					<input type="text" value="2">
					<span class="text">页</span>
					<span class="btn">确定</span>
				</div>
			</div>
			--}}
			{{$businessCount->links()}}
		</div>
	</div>
@stop

@section('scripts')
	@parent
	<script type="text/javascript">
		jQuery(".slideBox").slide({mainCell:".bd ul",effect:"leftLoop",autoPlay:true});

		//网站 商品搜索跳转
		function search(){
			window.location.href="products?search="+$("#text_search").val(); 
		}
	</script>
@show




