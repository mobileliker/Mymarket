@extends('szy.layouts.shop-app')

@section('title')
我家菜市商铺 
@stop

@section('content')
<div class="content">
	<div class="ct-left">
		<div class="l-info">
			<div class="info-top"></div>
			<div class="info-title">
				<b>供应商信息</b>
			</div><br/>
			<span>奉节继橙</span>
			<div class="info-list">
				<li><b>店&nbsp;&nbsp;&nbsp;&nbsp;铺</b>: *****</li>
				<li><b>所&nbsp;在&nbsp;地</b>: ********</li>
				<li><b>产品供应量</b>: <em>4216</em></li>
				<li><b>店铺访问量</b>: <em>64512</em></li>
			</div>
			<li class="info-li"><img src="inc/attention.png"><b> 关注店铺</b></li>
			<li class="info-li"><img src="inc/consult.png"><b> 咨询客服</b></li>
		</div>
		<div class="l-info">
			<div class="info-top"></div>
			<div class="info-title">
				<b>联系我们</b>
			</div>
			<br/>
			<span>周星驰</span>
			<div class="info-list">
				<li><b>店 铺</b>: *********</li>
				<li><b>手 机</b>: *********</li>
				<li><b>电 话</b>: *********</li>
				<li><b>邮 箱</b>: *********</li>
				<li><b>传 真</b>: *********</li>
				<li><b>地 址</b>: *********</li>
				<li><b>邮 编</b>: *********</li>
			</div>
		</div>
		<div class="l-suggest">
			<div class="sg-title">店家推荐</div>
			<li class="sg-list">
				<div class="list-img"><a href=""><img src="tj.png"></a></div>
				<div class="list-title"><a href="">*********是地方司法舒服撒防守对方说的分手费规范的风格打手犯规*</a></div>
				<div class="list-money">￥ 88.00</div>
			</li>
			<li class="sg-list">
				<div class="list-img"><a href=""><img src="tj.png"></a></div>
				<div class="list-title"><a href="">**********</a></div>
				<div class="list-money">￥ 88.00</div>
			</li>			<li class="sg-list">
				<div class="list-img"><a href=""><img src="tj.png"></a></div>
				<div class="list-title"><a href="">**********</a></div>
				<div class="list-money">￥ 88.00</div>
			</li>
		</div>
	</div>

	<div class="ct-right">
		<div class="r-desc">
			<div class="desc-bg"></div>
			<div class="desc-text"><br>
				<span>刘德华</span>
				<div class="text">你是我心中的玫瑰花*</div>
			</div>
		</div>

		<div class="product-title"><b>|</b> 所有商品</div>
		<div class="product-order">
			<li class="active">综合排序<span class="jt-footer"></span></li>
			<li>销量<span class="jt-top"></span></li>
			<li>价格<span class="jt-top"></span></li>
			<li>发布时间<span class="jt-top"></span></li>
		</div>
		<div class="product-list"> 
			<div class="list-single">
				<div class="sin-img"><a href=""><img src="tj.png"></a></div>
				<div class="sin-money"><b>￥ 56.90</b> 9.00/kg</div>
				<div class="sin-title"><b>************</b></div>
				<div class="sin-sell">
					<li>月成交<b>189</b>笔</li>
					<li>评价 <b>158</b></li>
				</div>
			</div>
			<div class="list-single">
				<div class="sin-img"><a href=""><img src="dp-logo.png"></a></div>
				<div class="sin-money"><b>￥ 56.90</b> 9.00/kg</div>
				<div class="sin-title"><b>************</b></div>
				<div class="sin-sell">
					<li>月成交<b>189</b>笔</li>
					<li>评价 <b>158</b></li>
				</div>
			</div>
		</div>
	</div>
	<div class="page">
		<div class="center">
			<button>上一页</button>
			<button>1</button>
			<button>2</button>
			<button>1</button>
			<button>...</button>
			<button>8</button>
			<button>9</button>
			<button>下一页</button>
		</div>
	</div>
</div>
@stop

@section('scripts')
@parent
<script type="text/javascript">
	jQuery(".slideBox").slide({mainCell:".bd ul",effect:"leftLoop",autoPlay:true});
</script>
@show