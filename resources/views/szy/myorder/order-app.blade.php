<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" ng-app="AntVel">
<head>
	@section('metaLabels')
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="/">
		<meta name="description" content="">
		<meta name="author" content="">
	@show

	<link rel="icon" href="favicon.ico">
	<title>@section('title'){{ $main_company['website_name']}} @show</title>



	{{-- Antvel CSS files --}}
	{!! Html::style('/antvel-bower/bootstrap/dist/css/bootstrap.css') !!}

	@section('css')
		{!! Html::style('/css/szy/common.css') !!}
		{!! Html::style('/css/szy/wishes-header.css') !!}
		{!! Html::style('/css/szy/top.css') !!}
		{!! Html::style('/css/szy/footer.css') !!}
	@show

</head>
<body>

@section('celerity')
	@include('szy.layouts.celerity')
@show




@section('header')
	@include('szy.layouts.top')
	@include('szy.layouts.wishes-header')
@show

<div class="order-div">
    <div class="left">           
        <li>订单中心</li>
        <li><a href="user/orders" @if($orderType=='myorder')class="action-li"@else class='default-li'@endif>我的订单</a></li>
        @if(auth::user()->role=='admin' || auth::user()->role=='business')
        <li><a href="orders/usersOrders" @if($orderType=='sellorder')class="action-li"@else class='default-li'@endif>我的销售</a></li>
        @endif
        <li><a href="" class="default-li">团购订单</a></li>
        <li>关注中心</li>
        <li><a href="wishes" class="default-li">关注的商品</a></li>
        <li><a href="wishes/shop" class="default-li">关注的店铺</a></li>
        <li><a href="" class="default-li">关注的活动</a></li>
    </div>
    <div class="right">

	@section('content')

	@show
	</div>
</div>

@section('footer')

	@include('szy.layouts.footer')

@show


@section('scripts')
	{!! Html::script('/antvel-bower/bootstrap/dist/js/bootstrap.min.js') !!}
	{!! Html::script('/js/szy/jquery1.42.min.js') !!}
	{!! Html::script('/js/szy/jquery.SuperSlide.2.1.1.js') !!}
@show

</body>
</html>
