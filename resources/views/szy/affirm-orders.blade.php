@extends('szy.layouts.orders-pay-app')

@section('title')
我家菜市 - 订单确认 
@stop

@section('css')
    {!! Html::style('/css/szy/orders-pay.css') !!}
@stop

@section('content')
    <div class="comfirmOrder"  @if (count($addresses) == 0) address="false" @else address="{{$addresses[0]->id}}" @endif>
        <div class="order_address">
            <h2>选择收货地址</h2>
            <div class="inner">
                @if (count($addresses) == 0)
                    <h1>没有地址 请添加</h1>
                @else
                    @foreach ($addresses as $address)
                    <div class="list" vl="{{$address->id}}">
                        <div class="addr_hd">
                            <span class="name">{{ $address->name_contact }}</span>
                            <span>({{ $address->state}} {{$address->city }})</span>
                        </div>
                        <div class="addr_bd">
                            <span class="street">{{$address->line1}}</span>
                            <br/>
                            <span class="phone">{{ $address->phone }}</span>
                        </div>
                    </div>
                    @endforeach
                @endif

            </div>
            <div class="control">
                <a href="javascript:void(0);" id="showAddress" state=0>全部地址显示</a>
                <a href="user/address"  target="_black">管理收货地址</a>
            </div>
            <div class="pay_way">
                <h1>支付方式</h1>
                <div class="items">
                    <ul check="false" id="payType">
                        <li paytype='-1'><a href="javascript:void(0);">线下支付</a></li>
                        {{--<li paytype=''><a href="javascript:void(0);">在线支付</a></li>--}}
                        <li paytype=''><a href="javascript:void(0);">微信支付</a></li>
                        {{--<li paytype=''><a href="javascript:void(0);">支付宝支付</a></li>--}}
                        {{--<li paytype=''><a href="javascript:void(0);">货到付款</a></li>--}}
                    </ul>
                    <span>线上功能暂时未开通,敬请期待！</span>
                </div>
            </div>
        </div>
        @foreach($business_products as $key=>$products)
            <div class="order_confirm">
                <h2 class="buy_th_title">订单确认 (商品)</h2>
                <div class="buy_th">
                    <div class="buy_td">店铺：<?php echo App\Business::find($key)->select('business_name')->first()->business_name; ?></div>
                    <div class="buy_td">价格(元)</div>
                    <div class="buy_td">数量</div>
                    <div class="buy_td">优惠(元)</div>
                    <div class="buy_td">总计(元)</div>
                    <div class="buy_td">配送方式</div>
                </div>
            </div>
            @foreach ($products as $product)
            <div class="order_item">
                <div class="order_itemInfo">
                    <div class="info_detail">
                        <div class="info_img">
                            <a href="products/{{ $product->id }}">
                                <img src="{{ json_decode($product->features)->{'images'}[0] }}" alt="">
                            </a>
                        </div>
                        <div class="info_cell">
                            <a href="products/{{ $product->id }}" class="info_title">{{ $product->name }}</a>
                            {{--<span class="kg">5斤装</span>--}}
                        </div>
                    </div>
                    <div class="info_price">￥{{ $product->price }}</div>
                </div>
                <div class="order_quantity">
                    <div class="quantity_inner">
                        <span class="details-pro" detailsid={{$product->details_id}}>
                            @if(isset($isResume))
                                {{ $product->quantity }}
                            @else
                                <strong>
                                        <span>{{ $product->quantity }}</span>
                                </strong>
                            @endif
                        </span>
                        {{--
                        <span class="quantity_left_minus">-</span>
                        <input type="text" class="amount" value="1" >
                        <span class="quantity_left_add">+</span>--}}
                    </div>                      
                </div>
                <div class="order_privilege">
                    <div class="privilege_selecter">
                        <span>0.00</span>
                    </div>
                </div>
                <div class="order_itemPay">
                    <span class="oneProductPrice">{{$product->quantity * $product->price}}</span>
                </div>
                <div class="delivery_way">
                    <select>
                        <option value="快递 免邮">快递 免邮</option>
                        <option value="不满5斤 邮费5元">不满5斤 邮费5元</option>
                    </select>
                </div>
            </div>
            @endforeach
        @endforeach

        <div class="order_Ext">
            <div class="order_memo">
                <label for="" class="memo_name">给卖家留言：</label>
                <div class="memo_detail">
                    <textarea class="text_area_input" placeholder="选填，可填写您和卖家达成一致的要求"></textarea>
                </div>
            </div>

        </div>
        <div class="order_payinfo">
            <div class="order_realPay">
                <span class="realPay_title">实付款:</span>
                <span class="order_price">￥</span>
                <span class="order_price" id="countPrice"></span>
            </div>
        </div>
        <div class="order_submit">
            <div class="wrap" id="orderSubmit">
                <a href="javascript:void(0);">提交订单</a>
            </div>
        </div>
    </div>

    <form action="user/orders/pay" method="POST" id="orderForm">
        {{ csrf_field() }}

        <input type='hidden' name="address_id" value="">
        <input type='hidden' name="paytype" value="">
        <input type='hidden' name="remarks" value="">
        <input type='hidden' name="details_ids" value="">
    </form>

    <form action="user/orders/pay/successful" method="POST" id="fulForm">
        {{ csrf_field() }}

        <input type='hidden' name="address_id" value="">
        <input type='hidden' name="paytype" value="">
        <input type='hidden' name="remarks" value="">
        <input type='hidden' name="details_ids" value="">
    </form>
@stop {{-- end content --}}

@section('scripts')
    @parent
    <script type="text/javascript">

        //商品订单id数据加入到Form
        var details = Array();
        $(".details-pro").each(function(i){
            details[i] = $(this).attr('detailsid');
        });
        $("input[name='details_ids']").val(details);

        //订单提交
        $("#orderSubmit").click(function(){
            var pay = $("#payType").attr('check');
            if ( pay != 'false') {
                if (pay != -1) {
                    $("#orderForm input[name='address_id']").val($(".comfirmOrder").attr('address'));
                    $("#orderForm input[name='paytype']").val(pay);
                    $("#orderForm input[name='remarks']").val($(".text_area_input").val());
                    $("#orderForm").submit();
                }else{
                    $("#fulForm input[name='address_id']").val($(".comfirmOrder").attr('address'));
                    $("#fulForm input[name='paytype']").val(pay);
                    $("#fulForm input[name='remarks']").val($(".text_area_input").val());
                    $("#fulForm").submit();
                }
            }else{
                alert('请选择支付方式');
            }
        });

        var count = 0;
        //支付总金额
        $(".oneProductPrice").each(function(){
            count = parseInt(count) + parseInt($(this).html());
        });
        $("#countPrice").html(count);

        //支付方式
        $("#payType li").click(function(){
            $("#payType li").css('border','1px solid #c5cecd');
            $("#payType li a").css('color','#c5cecd');
            $(this).css('border','1px solid #798281');
            $(this).children('a').css('color','#292929');
            $("#payType").attr('check',$(this).attr('paytype'));
        });

        //卖家留言
        $(".text_area_input").focus(function(){
            $(this).css('height','100px');
        }).blur(function(){
            $(this).css('height','20px');
        });

        //显示 隐藏 地址
        $("#showAddress").click(function(){
            if ($(this).attr('state')>0) {
                $(".inner").css('height','125px');
                $(this).attr('state',0);
                $(this).html('全部地址显示');
            }else{
                $(".inner").css('height','auto');
                $(this).attr('state',1);
                $(this).html('部分地址显示');
            }
        });

        //选择地址
        $(".list").click(function(){
            $(".comfirmOrder").attr('address',$(this).attr('vl'));
            $(".list").css('background','url(/img/szy/inc/frame1.png) no-repeat');
            $(this).css('background','url(/img/szy/inc/frame.png) no-repeat');
        });
    </script>
@show
