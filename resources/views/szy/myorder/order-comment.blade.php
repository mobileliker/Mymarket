@extends('szy.myorder.order-app')

@section('title')
我家菜市 - 订单评价
@stop

@section('css')
    @parent
    {!! Html::style('/css/szy/order-comment.css') !!}
    {!! Html::style('/css/szy/order-list.css') !!}
@stop

@section('content')
	<div class="title">订单评价</div>
	<div class="number-date">订单编号:<a href="user/orders/show/{{$order->id}}">{{$order->seller_id}}</a> &nbsp;&nbsp;{{$order->created_at}}</div>
	<div class="comments">
		<form action="user/orders/storeComment" method="POST" enctype="multipart/form-data" id="isForm">
			<input type="hidden" name="_token"  value="{{csrf_token()}}"/>
			<input type="hidden" name="order_id"  value="{{$order->id}}"/>
			<div class="public-comment">
				@if(empty($orderDetailCheck))
				<div class="rt-pj2">
					<span>物流满意度</span>
					<div class="xx star" >
						<input type="hidden" value=0 name="delivery">
						<li class="star-five" num=1>☆</li>
						<li class="star-five" num=2>☆</li>
						<li class="star-five" num=3>☆</li>
						<li class="star-five" num=4>☆</li>
						<li class="star-five" num=5>☆</li>
					</div>
				</div>
				
				<div class="rt-pj2">
					<span>服务满意度</span>
					<div class="xx star" >
						<input type="hidden" value=0 name="sever">
						<li class="star-five" num=1>☆</li>
						<li class="star-five" num=2>☆</li>
						<li class="star-five" num=3>☆</li>
						<li class="star-five" num=4>☆</li>
						<li class="star-five" num=5>☆</li>
					</div>
				</div>
				@endif
			</div>
			@foreach($orderProductFirsts as $orderProductFirst)
			<div class="comment-info">
				<div class="cm-left">
					<div class="lf-border">
						<div class="lf-pd-img"><a href="products/{{$orderProductFirst->pid}}" target="_black"><img src="{{json_decode($orderProductFirst->features)->{'images'}[0]}}"></a></div>
						<div class="lf-pd-name"><a href="products/{{$orderProductFirst->pid}}" target="_black">{{$orderProductFirst->name}}</a></div>
						<div class="lf-pd-price">￥{{$orderProductFirst->price}}</div>
						<div class="lf-pd-gg">
							@foreach(json_decode($orderProductFirst->features) as $title=>$value)
								@if($title!='images')
									{{$title}}:{{$value}}&nbsp;
								@endif 
							@endforeach
						</div>
					</div>
				</div>

				<div class="cm-right">
					<div class="hint">如实对商品评价对其它买家有帮助哦~</div>
					<div class="rt-pj">
						<span>商品满意度</span>
						<div class="xx star"  num="">
							<input type="hidden" value=1 name="data[{{$orderProductFirst->details_id}}]['product']">
							<li class="star-five" num=1>★</li>
							<li class="star-five" num=2>☆</li>
							<li class="star-five" num=3>☆</li>
							<li class="star-five" num=4>☆</li>
							<li class="star-five" num=5>☆</li>
						</div>
						&nbsp;&nbsp;&nbsp;星星越多表示评价越高哦~
					</div>

					<div class="pj-content">
						<span>商品评价</span>
						<div class="pj-text">
							<input name="data[{{$orderProductFirst->details_id}}]['content']" type="text" maxlength="200">
							&nbsp;&nbsp;共200字,还能编写 <b>200</b> 字。
						</div>
					</div>
					<div class="pj-content">
						<span>图片上传</span>
						<div class="pj-text">
							<div class="pj-image">
								<div class="image-click"><img src="img/szy/inc/upload-img.png" class="uploads" ></div>
								<div class="image-upload">
									<input type='file' name="images{{$orderProductFirst->details_id}}[]" style='display:none' class='file1' onchange="fileChange(this);">
									<input type='file' name="images{{$orderProductFirst->details_id}}[]" style='display:none' class='file2' onchange="fileChange(this);">
									<input type='file' name="images{{$orderProductFirst->details_id}}[]" style='display:none' class='file3' onchange="fileChange(this);">
									<input type='file' name="images{{$orderProductFirst->details_id}}[]" style='display:none' class='file4' onchange="fileChange(this);">
									<input type='file' name="images{{$orderProductFirst->details_id}}[]" style='display:none' class='file5' onchange="fileChange(this);">
								</div>
							</div>
							&nbsp;&nbsp;共5张,还能上传 <b>5</b> 张。
						</div>
					</div>
				</div>
			</div>
			@endforeach
		<button type="button" onclick="submits();">提 交</button>
		</form>
	</div>
@stop

@section('scripts')
    @parent
    <script type="text/javascript">
    		
    	//表单提交
    	function submits(){
    		var content = $(".pj-text").eq(0).children('input').val();
    		var sever = $("input[name='sever']").val();
    		var delivery = $("input[name='delivery']").val();
    		if (delivery<1 || sever<1) {
    			alert('请对物流或服务评价！');
    			 window.scrollTo(0,0); 
    		}else{
    			if (content=='') {
    				alert('请完善评价内容！');
    			 	window.scrollTo(0,200); 
    			}else{
    				alert('评价成功！');
    				$("#isForm").submit();
    			}
    		}
    	}

    	//文本框字数变化
    	$(".pj-text input").keyup(function(){
    		var len = 200-$(this).val().length;
    		$(this).next('b').html(len);
    	});

    	//图片上传
    	var m=1;
    	$(".uploads").click(function(){
    		if (m<6) {
    			$(this).parent('.image-click').next('.image-upload').children(".file"+m).click();
    		}else{
    			alert('最多上传5张图片！');
    		}
    	})

    	//上传change
    	function fileChange(th){
    		var $th = $(th);
            var reader = new FileReader();
            reader.readAsDataURL(th.files[0]);
            //监听文件读取结束后事件
            reader.onloadend = function (e) {
    			$th.parent(".image-upload").append("<img src='"+e.target.result+"'>");
    			m++;
    			var len = 5 - $th.parent(".image-upload").children('img').length;
    			$th.parent(".image-upload").parent(".pj-image").next('b').html(len);
            };
    	}	

    	//星星评价
    	$(".star-five").mouseover(function(){
    		var num = $(this).attr('num');
    		$(this).parent('.star').children('input').val(num);
    		
    		for(var i=0;i<num;i++){
    			$(this).parent('.star').children('li').eq(i).html('★');
    		}
    		for(var j=num;j<6;j++){
    			$(this).parent('.star').children('li').eq(j).html('☆');
    		}
    	});
    </script>
@show