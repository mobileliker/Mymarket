@extends('szy.layouts.product-app')

@section('title')
商品详情页
@stop



@section('content')
	<!-- 商品详情页内容 -->
	<div class='details'>
		<div class='product'>
			<div class="left">
				<div class="max-pic">
					<img src="{{$product->features['images'][0]}}">
				</div>
				<div class="min-pic">
					<?php $num=0; ?>
					@foreach($product->features['images'] as $image)
						<?php $num++; ?>
						@if($num<5)
						<li><img src="{{$image}}"></li>
						@endif
					@endforeach
				</div>
				<div class="info">
					<div class="bh">商品编号:10241544545</div>
					<div class="sy"><img src="/img/szy/inc/search.png"><span class="sy-span">商品溯源</span> 
						<div class="ewm" state='n'><img src="{{$product->code}}"></div>
					</div>
					<div class="gz"><img src="/img/szy/inc/collect.png">关注商品</div>
				</div>
			</div>
			<div class="pm">
				<div class="title">{{$product->name}}</div>
				<div class="desc">{{$product->description}}</div>
				<div class="price">
					<div class="left">
						<div class="pre">
							<div class="l">价格</div>
							<div class="r">￥88.00</div>
						</div>
						<div class="next">
							<div class="l">促销价</div>
							<div class="r">￥{{$product->price}}</div>
						</div>
					</div>
					<div class="right">
						<div class="pre">月销量 <b>1554</b></div>
						<div class="next">累计评价 <b>1545</b></div>
					</div>
				</div>
				<div class="delivery">
					<div class="ps">
						配送至:
						<select>
							<option>重庆朝天门</option>
							<option>重庆铜梁安居古镇</option>
						</select>
						有货 &nbsp; 免邮费
					</div>
					<div class="fw">
						服 务:由<a href="">生之园</a>从广州市提供发货,并提供售后服务
						@if ($product->stock <= $product->low_stock)
							<span class = "label label-warning">{{ trans('store.lowStock') }}</span>
						@else
							<span class = "label label-success">{{ trans('store.inStock') }}</span>
						@endif
					</div>
				</div>
				<div class="cs">
					<div class="lf">选择规格:</div>
					<div class="rt">
						<li>5kg/箱</li>
						<li>8kg/箱</li>
						<li>10kg/箱</li>
						<li>15kg/箱</li>
					</div>
				</div>
	            <form action="user/orders/addTo/cart/{{$product->id}}" method="POST">
                    <input name="_method" type="hidden" value="PUT">
                    {{ csrf_field() }}
                    <input type="submit" style="display:none" id="cart_submit">
                </form>
				<div class="submit">
					<button>立即购买</button>
					<div class="gwc">
						<a href="javascript:void(0);" onclick="$('input[id=cart_submit]').click();">
							<img src="/img/szy/inc/add-cart.png"> 
							加入购物车
						</a>
					</div>
					<div class="num">
						<input type="text" value="1">
						<li>+</li>
						<li style="border-top:1px solid #4D4D4D;">-</li>
					</div>
				</div>
			</div>

			<div class="serve">
				<div class="title">
					<a href="">广州天河生之园</a>
				</div>
				<div class="zs">
					<div class='lf'>9.65</div>
					<div class="rt">
						<li>商品评价 9.65 <img src="/img/szy/inc/jt-footer.png"></li>
						<li>服务评价 9.65 <img src="/img/szy/inc/jt-footer.png"></li>
						<li>物流评价 9.65 <img src="/img/szy/inc/jt-footer.png"></li>
					</div>
				</div>
				<div class="lx">
					<li><a href=""><img src="/img/szy/inc/phone.png"> 联系卖家</a></li>
					<li><a href=""><img src="/img/szy/inc/consult.png"> 咨询客服</a></li>
					<li><a href=""><img src="/img/szy/inc/shop.png"> 进店逛逛</a></li>
					<li><a href=""><img src="/img/szy/inc/attention.png"> 关注商铺</a></li>
				</div>
			</div>
		</div>

		<div class="content">
			<div class="left">
				<div class="ewm">
					<div class="title">店铺二维码</div>
					<div class="img"><img src="./eq.png"></div>
					<span>扫一扫,进入手机店铺</span>
				</div>
				<div class="tj-p">
					<div class="title">店家推荐</div>
					@if($sells!="")
					@foreach($sells as $sell)
					<li class="product-list">
						<div class="p-img">
							<a href="products/{{$sell->id}}"><img src="{{json_decode($sell->features)->{'images'}[0]}}"></a>
						</div>
						<div class='p-desc'>
							<a href="">{{$sell->name}}</a></div>
						<div class='p-price'>￥{{$sell->price}}</div>
					</li>
					@endforeach
					@endif
				</div>
			</div>
			<div class="right">
				<div class="desc">
					<div class="d-title">
						<div class="tt-t">商品详情</div>
					</div>
					<div class="d-pp">
						品牌名称: <a href="">{{ ucwords($product->brand) }}</a>		
					</div>
					<div class="d-mc">产品参数:</div>
					<div class="d-xx">
						<div class="xx-san">
						<li>国产/进口: <span>@if($product->import)进口@else国产@endif</span></li>
						<li>生产日期: <span>{{$product->plan_date}}</span></li>
						</div >
						<div class="xx-san">
					@foreach ($product->features as $key => $feature)
						@if ($key != 'images' && $key=='重量')
							<li>重量: <span>{{  ucwords( is_array($feature) ? implode(' ', $feature) : $feature ) }}</span></li>						
						@endif
					@endforeach
						<li>产地: <span>{{$product->origin}}</span></li>
						</div>
						<div class="xx-san">
						<li>包装: <span>{{$product->pack}}</span></li>
						<li>保质期:<span>{{$product->quality_time}}天</span></li>
						</div>
					</div>
					{{--
					<div class="d-date">
						&nbsp;生产日期: <span>2016-10-01</span>
						 至 <span>2010-10-05</span> 
					</div>--}}
				</div>
				<div class="desc-img">
					<div class="img-center">
						<img src="./image/desc-img.png">
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('scripts')
   @parent
<script type="text/javascript">
	//大小图切换
	$(".min-pic li img").click(function(){
		$(".max-pic img").attr('src',$(this).attr('src'));
	});

	// 溯源码查看
	$(".sy-span").click(function(){
		var state = $(this).next('.ewm').attr('state');
		if (state=='n') {
			$(this).next('.ewm').show();
			$(this).next('.ewm').attr('state','y');
		}else{
			$(this).next('.ewm').css('display','none');
			$(this).next('.ewm').attr('state','n');
		}
	});
	$(".info .sy .ewm").mouseleave(function(){
		$(this).css('display','none');
		$(this).attr('state','n');
	});
</script>

@show