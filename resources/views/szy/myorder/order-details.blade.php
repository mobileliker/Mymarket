@extends('szy.myorder.order-app')

@section('title')
我家菜市 - 订单详情 
@stop

@section('css')
    @parent
    {!! Html::style('/css/szy/order-details.css') !!}
    {!! Html::style('/css/szy/order-list.css') !!}
@stop

@section('content')
	<div class="title">订单详情</div>
	<div class="order-details">
		<div class="flow-img">
			<div class="details-title">
			您好！订单 53452345 

			@if($order->status=='cancelled')
				处于取消状态...
			@endif 

			@if($order->status=='pending')
				处理中...
			@endif 

			@if($order->status=='open')
				处于未支付状态...
			@endif 

			@if($order->status=='paid')
				已付款,等待商品出库...
			@endif 

			@if($order->status=='received')
				已签收! <a href="user/orders/comment/{{$order->id}}">立即评价</a>
			@endif 

			@if($order->status=='sent')
				商家已发货,等待收货...
			@endif 

			@if($order->status=='closed')
				订单已完成！
			@endif 
			</div>
			<div class="pd-img-d @if($order->status=='open') opacity-n @else opacity-y @endif"><div><img src="img/szy/inc/flow-order.png"></div><span>提交订单</span></div>
			<div class="pd-img-c @if($order->status=='open') opacity-n @else opacity-y @endif"><img src="img/szy/inc/flow-r.png"> </div>
			<div class="pd-img-d @if($order->status=='paid') opacity-n @else opacity-y @endif"><div><img src="img/szy/inc/flow-pay.png"></div><span>付款成功</span> </div>
			<div class="pd-img-c @if($order->status=='paid') opacity-n @else opacity-y @endif"><img src="img/szy/inc/flow-r.png"> </div>
			<div class="pd-img-d @if($order->status=='sent') opacity-n @else opacity-y @endif"><div><img src="img/szy/inc/flow-come.png"></div><span>商品出库</span> </div>
			<div class="pd-img-c @if($order->status=='sent') opacity-n @else opacity-y @endif"><img src="img/szy/inc/flow-r.png"> </div>
			<div class="pd-img-d @if($order->status=='received') opacity-n @else opacity-y @endif"><div><img src="img/szy/inc/flow-delivery.png"></div><span>货物签收</span></div>
			<div class="pd-img-c @if($order->status=='received') opacity-n @else opacity-y @endif"><img src="img/szy/inc/flow-r.png"></div>
			<div class="pd-img-d @if($order->status=='closed') opacity-n @else opacity-y @endif"><div><img src="img/szy/inc/flow-finish.png"></div><span>完成订单</span> </div>
		</div>
		<div class="order-products">
			<div class="details-title">订单商品</div>
			<?php 
				$detailsProducts = App\OrderDetail::where('order_id',$order->id)
				->join('products','order_details.product_id','=','products.id')
				->select('order_details.*','products.id as pid','products.name','products.features')
				->get();
			 ?>
			@foreach($detailsProducts as $detailsProduct)
			<div class="list-product">
				<a href="products/{{$detailsProduct->pid}}"  target="_black"><img src="{{json_decode($detailsProduct->features)->{'images'}[0]}}"></a>
				<div class="pt-info1"><a href="products/{{$detailsProduct->pid}}"  target="_black">{{$detailsProduct->name}}</a></div>
				<div class="pt-info2">×<b>{{$detailsProduct->quantity}}</b> &nbsp;&nbsp;&nbsp; ￥<b>{{$detailsProduct->price}}</b></div>
				<div class="select-comment">
					@if(empty($detailsProduct->reply))
						<a href="javascript:void(0);" class="comment-reply" pid="{{$detailsProduct->id}}">评论回复</a>
					@endif
				</div>
				<div class="show-comment">
					{{$detailsProduct->rate_comment}}

					<div class="max-image"><img src=""></div>

					@if(!empty($detailsProduct->image))
					<div class="cm-images">
						@foreach(explode(',',$detailsProduct->image) as $img)
						<img src="{{$img}}">
						@endforeach
					</div>
					@endif
				</div>
				@if(!empty($detailsProduct->reply))
				<div class="reply">
					<p>评论回复:</p> 
					<div class="reply-text">
						{{$detailsProduct->reply}}
					</div>
				</div>
				@endif
			</div>
			@endforeach	
		</div>

		@if($order->status=='received' || $order->status=='closed' || $order->status=='sent')
			<div class="order-products">
				<div class="details-title">物流信息 </div>
				<div class="delivery-info">
					2016-12-06 07:44:09我家菜市配送员【朱伟建】已出发，联系电话【13822246452，感谢您的耐心等待，参加评价还能赢取京豆呦】
					<br>
					<br>
					2016-12-06 07:13:28您的订单在我家菜市【华南理工五山校区我家菜市派】验货完成，正在分配配送员
					<br>
					<br>
					2016-12-06 07:13:26您的订单在我家菜市【华南理工五山校区我家菜市派】收货完成
					<br>
					<br>
					2016-12-06 07:13:20您的订单在我家菜市【华南理工五山校区我家菜市派】验货完成，正在分配配送员
					<br>
					<br>
					2016-12-06 07:13:18您的订单在我家菜市【华南理工五山校区我家菜市派】收货完成
					<br>
					<br>
					2016-12-06 06:09:38您的订单在我家菜市【华南理工五山校区我家菜市派】收货完成
					<br>
					<br>
					2016-12-06 02:04:47您的订单在我家菜市【广州博展分拣中心】发货完成，准备送往我家菜市【华南理工五山校区我家菜市派】
					<br>
					<br>
					2016-12-05 22:03:29您的订单在我家菜市【广州博展分拣中心】分拣完成
					<br>
					<br>
					2016-12-05 20:52:56您的订单在我家菜市【广州博展分拣中心】收货完成
					<br>
					<br>
					2016-12-05 20:52:30您的订单在我家菜市【广州博展分拣中心】收货完成
					<br>
					<br>
					2016-12-04 18:53:40您的订单在我家菜市【武汉外单分拣中心】发货完成，准备送往我家菜市【广州博展分拣中心】
					<br>
					<br>
					2016-12-04 18:53:10您的订单在我家菜市【武汉外单分拣中心】分拣完成
					<br>
					<br>
					2016-12-04 17:06:18您的订单在我家菜市【武汉外单分拣中心】收货完成
				</div>
			</div>
		@endif

		<?php 
			$address = App\Address::find($order->address_id);
			$sellerRole = App\User::find($order->seller_id)->role;
			if ($orderType=='myorder') {
				$business = App\Business::where('user_id',$order->seller_id)->first();
			}else{
				$business = App\Business::where('user_id',$order->user_id)->first();
			}

		 ?>
		<div class="order-products">
			<div class="details-title">订单信息 </div>
			<div class="info-left">
				<li>收货地址: @if(!empty($address)){{$address->state}}{{$address->city}}{{$address->line1}}@endif</li>
				<li>收货人: @if(!empty($address)){{$address->name_contact}}@endif</li>
				<li>您的电话: @if(!empty($address)){{$address->phone}}@endif</li>
			</div>
			<div class="info-right">
				@if($sellerRole!='admin' && $sellerRole!='person' && $business!='')
					<li>店铺: {{$business->business_name}}</li>
					<li>负责人: {{$business->person}}</li>
					<li>商家电话: {{$business->phone}}</li>
				@else
					<li>网站自营 (卖家)</li>
				@endif
			</div>
		</div>
	</div>

	<div class="opt">
		<div class="reply-opt">
			<br>
			<span> &nbsp;评论回复：</span>
			<textarea cols=70 rows=8 >

			</textarea>
			<button onclick="replySubmit()" pid="" id="replySubmit">提交回复</button>
			<button onclick="replyClear();">取消</button>
		</div>
	</div>
@stop

@section('scripts')
    @parent
    <script type="text/javascript">
    	$(".cm-images img").click(function(){
    		$(this).parent('.cm-images').siblings(".max-image").children("img").attr('src',$(this).attr('src'));
    		$(this).parent('.cm-images').siblings(".max-image").show();
    	});
	$(".comment-reply").click(function(){
		$(".opt").show();
		$(".opt #replySubmit").attr('pid',$(this).attr('pid'));
	});
	function replyClear(){
		$(".reply-opt textarea").val('');
		$("#replySubmit").attr('pid','');
		$(".opt").hide();
	}
	function replySubmit(){
		$(".opt").hide();
		var text = $(".reply-opt textarea").val();
		var v = $("#replySubmit").attr('pid');
		$.get("user/orders/commentReply", { id: v, reply: text },
		  function(data){
		    if(data){
		    	alert('回复评论成功！');
		    	$(".comment-reply[pid='"+v+"']").hide();
		    	$(".comment-reply[pid='"+v+"']").parent('div').parent('div').append("<div class='reply'><p>评论回复:</p><div class='reply-text'>"+text+"</div></div>");
		    }else{
		    	alert('回复评论失败！');
		    }
		});
	}

    </script>
@show