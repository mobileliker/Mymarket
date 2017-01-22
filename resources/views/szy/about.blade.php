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
    <title>我家菜市 - 帮助中心</title>
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
    <div class="help-main">
        <div class="subside-box">
            {{--<h3>常见问题分类</h3>--}}
            <h3> 帮 助 中 心 </h3>

            @foreach(App\ArticleCategory::all() as $key=>$category)
                <dl>
                    @if($category->id == $article->category_id)
                        <dt class="default-show">{{$category->display_name}}<span class="active"></span></dt>
                    @else
                        <dt class="hide-arrow">{{$category->display_name}}<span class="hide-arrow"></span></dt>
                    @endif
                    <dd>
                        <ul>
                            @foreach($category->articles as $article2)
                                @if($article2->id == $article->id)
                                <li class="default-color">
                                @else
                                    <li>
                                 @endif
                                    <a href="{{url('/page/'.$article2->slug)}}">{{$article2->title}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </dd>
                </dl>
            @endforeach
            </div>
        <div class="content">
            <div class="breadcrumb">
                {{$article->title}}
            </div>
            <div class="tabs">
                <div class="tabcons">
                    {!!$article->content!!}
                </div>
            </div>
        </div>
    </div>

    @include('szy.layouts.footer')
 
    <form action="/user/orders/checkOut" method="GET" id="cartOrder">
        <input type="hidden" name="order_ids" value="">
    </form>
</body>

    {!! Html::script('/js/szy/jquery-1.8.3.min.js') !!}
    <script type="text/javascript">
      
        $(function(){

            //默认显示的标题
            $(".default-show").next('dd').show();

            // 点击标题事件
            $('.subside-box dl dt').click(function(e){
                if($(this).find('span').attr('class')!='active'){
                    $('.subside-box dl dd').slideUp();
                    $(this).next('dd').slideDown();
                    $('.subside-box dl dt span').removeClass('active').addClass('hide-arrow');
                    $(this).find('span').removeClass('hide-arrow').addClass('active');
                } else {
                    $(this).next('dd').slideUp();
                    $(this).find('span').removeClass('active').addClass('hide-arrow');
                }
            });
        });
    </script>
</html>

