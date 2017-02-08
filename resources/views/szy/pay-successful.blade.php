@extends('szy.layouts.orders-pay-app')

@section('title')
我家菜市 - 支付完成
@stop

@section('css')
    {!! Html::style('/css/szy/pay-successful.css') !!}
@stop

@section('content')

@if(!empty($orderinfos))
    @foreach($orderinfos as $sellerid => $orderinfo)
    <div class="success-tips">
        <span>支付成功！订单号:</span>
        <em>{{$orderinfo->order_number}}</em>
        <span>已成功生成，我们会尽快送达您的手中!</span>
    </div>
    <div class="order">
        <div class="left-semicircle"></div>
        <div class="right-semicircle"></div>
        <div class="order-inner">
            <div class="img">
                <img src="{{$orderinfo->logo}}" alt="">
            </div>
            <?php 
                $orderCount = App\OrderDetail::where('order_id',$orderinfo->order_id)->get();
                $priceCount=0;
                foreach ($orderCount as $value) {
                    $priceCount += $value->price;
                }
            ?>
            <div class="detail">
                <p>
                    <em>订单金额:</em>
                    <span>￥{{$priceCount}}</span>
                </p>
                <p>
                    <em>支付方式:</em>
                    <span>@if($paytype == -1) 线下支付 @endif</span>
                </p>
                <p>
                    <em>数量:</em>

                    <span>{{count($orderCount)}}</span>
                </p>
                <p>
                    <em>配单由</em>
                    <a href="">{{$orderinfo->business_name}}</a>
                    <em>发货，送达时间以商家为准</em>
                </p>
                <p>
                    <em>收货地址:</em>
                    <span>{{$orderinfo->state}} {{$orderinfo->city}} {{$orderinfo->line1}}</span>
                </p>
                <div class="btn">
                    <a href="user/orders">查看订单</a>
                    <a href="/home">返回首页</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@else
    <span>订单提交错误！</span>
@endif
@stop {{-- end content --}}

@section('scripts')
    @parent
    <script type="text/javascript">
        if({{$checkSubmit}}){
            alert('你已提交过订单！');
        }

    </script>
@stop
