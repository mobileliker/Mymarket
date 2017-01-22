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
            <dl>
                <dt class="default-show">支付方式<span class="active"></span></dt>
                <dd>
                    <ul>
                        <li class="default-color">
                            <a href="#">快捷支付</a>
                        </li>
                        <li>
                            <a href="#">支付宝</a>
                        </li>
                        <li>
                            <a href="#">信用卡</a>
                        </li>
                        <li>
                            <a href="#">货到付款</a>
                        </li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt>商家服务<span class="hide-arrow"></span></dt>
                <dd>
                    <ul>
                        <li>
                            <a>我要供货</a>
                        </li>
                        <li>
                            <a>物流服务</a>
                        </li>
                        <li>
                            <a>供货规则</a>
                        </li>
                        <li>
                            <a>运营服务</a>
                        </li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt>联系我们<span class="hide-arrow"></span></dt>
                <dd>
                    <ul>
                        <li>
                            <a>服务电话</a>
                        </li>
                        <li>
                            <a>微薄</a>
                        </li>
                        <li>
                            <a>邮箱</a>
                        </li>
                        <li>
                            <a>微信公众号</a>
                        </li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt>消费保障<span class="hide-arrow"></span></dt>
                <dd>
                    <ul>
                        <li>
                            <div></div>
                            <a>缺货陪衬</a>
                        </li>
                        <li>
                            <div></div>
                            <a>发票保障</a>
                        </li>
                        <li>
                            <div></div>
                            <a>售后规则</a>
                        </li>
                        <li>
                            <div></div>
                            <a>购物指南</a>
                        </li>
                    </ul>
                </dd>
            </dl>
        </div>
        <div class="content">
            <div class="breadcrumb">
                {{--  这里放对应的标题！！ --}}
                ...
            </div>
            <div class="tabs">
                <div class="tabcons">
                    {{--  这里放对应的内容！！ --}}
                    .....

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

