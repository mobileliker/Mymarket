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

	@show

</head>
<body>

@include('szy.layouts.top')

@section('celerity')
	@include('szy.layouts.celerity')
@show

@section('header')
	@include('szy.layouts.wishes-header')
@show

<div class="attent">
	<div class="attent-myself">
		我关注的
	</div>
	<div class="attent-main">
		<div class="attent-main-title">
			<ul class="nav-att">
				<a href="wishes" ><li @if($wisheType =='product') class="goods" @endif >关注的商品</li></a>
				<a href="wishes/shop"><li @if($wisheType =='shop') class="goods" @endif >关注的店铺</li></a>
			</ul>
			{{--
			<div class="search-goods">
				@if($wisheType =='product')
				<input type="text" placeholder=" 请输入商品名称">
				@else
				<input type="text" placeholder=" 请输入店铺名称">
				@endif 
				<a href=""><img src="/img/szy/inc/search1.png" alt="" class="search"></a>
			</div>
			--}}
		</div>
		{{--
		<div class="goods-navigation">
			<div class="navigation-inner">
				<div class="navigation">
					<div class="navigation-title">
						分类筛选:
					</div>
					<ul class="list">
						<li><a href="" class="all">全部</a></li>
						<li>
							<a href="">水果(4)</a>
						</li>
						<li>
							<a href="">蔬菜(11)</a>
						</li>
						<li>
							<a href="">肉类(3)</a>
						</li>
						<li>
							<a href="">干货(4)</a>
						</li>
						<li>
							<a href="">水产(4)</a>
						</li>
					</ul>
				</div>
				<div class="navigation">
					<div class="navigation-title">
						全部商品(25):
					</div>
					<ul class="list">
						<li><a href="" class="all">全部</a></li>
						<li>
							<a href="">降价(5)</a>
						</li>
						<li>
							<a href="">促销(10)</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		--}}
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
