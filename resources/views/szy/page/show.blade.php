<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" ng-app="AntVel">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="/">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>我家菜市 - {{$article->title}}</title>
    {{-- Antvel CSS files --}}
    {!! Html::style('/antvel-bower/bootstrap/dist/css/bootstrap.css') !!}
    {!! Html::style('/css/szy/help.css') !!}
</head>
<body>
@include('szy.layouts.top')
<header>
    <div class="header-main">
        <div class="logo">
            <a href="">
                <img src="img/szy/inc/logo.png" alt="">
                <b></b>
            </a>
        </div>
        <ul class="header-nav">
            {{--
            <li><a href="#">首页</a></li>
            <li><a href="#">常见问题</a></li>
            <li><a href="#">自助服务</a></li>
            <li><a href="#">联系客服</a></li>
            <li><a href="#">新手指南</a></li>
            --}}
        </ul>
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-lg-12" style="margin:20px;">
            {!! $article->content !!}
        </div>
    </div>
</div>
@include('szy.layouts.footer')

</body>

{!! Html::script('/js/szy/jquery-1.8.3.min.js') !!}

</html>

