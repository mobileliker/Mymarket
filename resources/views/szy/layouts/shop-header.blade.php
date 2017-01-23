
<div class="header" >
@include('szy.layouts.top')
	<div class="header-b">
		<div class="header-nav">
			<div class="header-nav-b">
				<div class="header-nav-b1"><a href="shop/{{$id}}"><img src="{{$business->logo}}"></a></div>
				<div class="header-nav-b2">
					{{--<div class="header-nav-b2-span1">店铺: {{$business->business_name}}</div>--}}
						
					<?php 
						$result = App\UserBusiness::where('user_id',auth()->user()->id)
												->where('business_id',$business->user_id)
												->first();
					?> 
					<span class="header-nav-b2-span2 attention-edit" bid={{$business->user_id}} @if($result) state=1 @else state=0 @endif>
						<img src="/img/szy/inc/attention.png">&nbsp;
						<span href="">
							@if($result)
								取消关注
							@else
								关注商铺
							@endif
						</span>
					</span>
				</div>
			</div>
			<div  class="header-nav-right">
				<div class="header-nav-right-l">
					<div class="header-nav-right-la">
						<input type="text" id="text_search" @if(isset($_GET['search']))value="{{$_GET['search']}}"@endif>
						<button class="header-nav-right-la-bt1" type="button" onclick="search();">搜全站</button>
						<button class="header-nav-right-la-bt2" type="button" onclick="search2();">搜本店</button>
						<div class="header-nav-right-la-cart">
							<a href="user/cart">
								<img src="/img/szy/inc/cart.png">
								我的购物车
							</a>
						</div>
					</div>

					<div class="header-nav-right-l-div">
						<span>推荐 :</span>
						@if(!empty($pushs))
							@foreach($pushs as $push)
							<a href="">{{$push->name}}</a>&nbsp;
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="header-c">
		<div class="header-theme">
			<div class="header-theme-center">
				{{--<li><a href="">主页</a></li>--}}
			</div>
		</div>
		<div class="header-c-fig slideBox" id="slideBox">
			<div class="hd">
				<ul><li>1</li><li>2</li><li>3</li></ul>
			</div>
			<div class="bd">
				@if(!empty($business->lbpic))
				<?php $bus = explode(',',$business->lbpic)?>
				<ul>
					@foreach($bus as $lb)
						@if(!empty($lb))
						<li><a href="" target="_blank"><img src="{{$lb}}" /></a></li>
						@endif
					@endforeach
				</ul>
				@endif
			</div>

			<!-- 下面是前/后按钮代码，如果不需要删除即可 -->
			<a class="prev" href="javascript:void(0)"></a>
			<a class="next" href="javascript:void(0)"></a>
		</div>
	</div>
</div>	


@section('scripts')
@parent
<script type="text/javascript">

	//店铺关注
	$(".attention-edit").click(function(){
		var state = $(this).attr('state');
		var bid = $(this).attr('bid');

		if (state>0) {
			
			delAttention(bid,$(this));
		}else{
			addAttention(bid,$(this));
			
		}
	})

	//关注商铺
	function addAttention(bid,tis){
		$.get("wishes/shop/attention/add?bid="+bid, function(result){
			if (result) {
				alert('关注成功！');
				tis.find('span').html('取消关注');
				tis.attr('state',1);
			}else{
				alert('关注失败！');
			}
        });
	}

	//取消关注商铺
	function delAttention(bid,tis){
		$.get("wishes/shop/attention/del?bid="+bid, function(result){
			if (result) {
				alert('取消关注成功！');
				tis.find('span').html('关注商铺');
				tis.attr('state',0);
			}else{
				alert('取消关注失败！');
			}
        });
	}
</script>
@show