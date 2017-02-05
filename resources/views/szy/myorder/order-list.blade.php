@extends('szy.myorder.order-app')

@section('title')
我家菜市 - 我的订单 
@stop

@section('css')
    @parent
    {!! Html::style('/css/szy/order-list.css') !!}
@stop

@section('content')

    <div class="title">
        我的订单
    </div>
    <?php 
        $amountAll = App\Order::where('user_id', \Auth::user()->id)->ofType('order')->count();
        $amountPending = App\Order::where('user_id', \Auth::user()->id)->ofType('order')->ofStatus('pending')->count();
        $amountSent = App\Order::where('user_id', \Auth::user()->id)->ofType('order')->ofStatus('sent')->count();
        $amountReceived = App\Order::where('user_id', \Auth::user()->id)->ofType('order')->whereIn('status', ['received', 'closed'])->count();
        $amountCancelled = App\Order::where('user_id', \Auth::user()->id)->ofType('order')->ofStatus('cancelled')->count();
    ?>

    <div class="order-type">
        <span onclick="orderAll();">全部订单 <div class="order-amount">{{$amountAll}}</div></span>
        <span onclick="orderPending();">待付款 <div class="order-amount">{{$amountPending}}</div></span>
        <span onclick="orderSent();">待收货 <div class="order-amount">{{$amountSent}}</div></span>
        <span onclick="orderReceived();">待评价 <div class="order-amount">{{$amountReceived}}</div></span>
        <span onclick="orderCancelled();">已取消 <div class="order-amount">{{$amountCancelled}}</div></span>
        
        <div class="search" onclick="searchs();"><img src="img/szy/inc/search1.png"></div>
        <input type="text" id="search" name="" @if(isset($_GET['search']))value="{{$_GET['search']}}"@endif placeholder=" 输入订单号">
    </div>
    <div class="order-title">
        <div class="t-product">商品详情</div>
        <div class="t-business">状态</div>
        <div class="t-user">收货人</div>
        <div class="t-price">金额(元)</div>
        <div class="t-operate">操作</div>
    </div>

    <div id="orderAll" class="order-hidden" style="display:block;">
        @include('szy.myorder.order-all') 
        <div class="page">{{$openOrders->links()}}</div>                
    </div>

    <div id="orderPending" class="order-hidden">
       @include('szy.myorder.order-pending')  
        <div class="page">{{$pendingOrders->links()}}</div>                
    </div>

    <div id="orderSent" class="order-hidden">
       @include('szy.myorder.order-sent')   
        <div class="page">{{$sentOrders->links()}}</div>                
    </div>

    <div id="orderReceived" class="order-hidden">
       @include('szy.myorder.order-received')  
        <div class="page">{{$unRate->links()}}</div>                
    </div>

    <div id="orderCancelled" class="order-hidden">
       @include('szy.myorder.order-cancelled')   
        <div class="page">{{$cancelledOrders->links()}}</div>                 
    </div>
    
@stop {{-- end content --}}

@section('scripts')
    @parent
    <script type="text/javascript">

    //显示所有订单
    function orderAll(){
        $(".order-hidden").css('display','none');
        $("#orderAll").show();
        $(".order-type span").css('color','#6F6F6F');
        $(".order-type span").eq(0).css('color','#12C974');
        $(".order-type span").css('border-bottom','none');
        $(".order-type span").eq(0).css('border-bottom','1px solid #12C974');
    }
    //显示待付款
    function orderPending(){
        $(".order-hidden").css('display','none');
        $("#orderPending").show();
        $(".order-type span").css('color','#6F6F6F');
        $(".order-type span").eq(1).css('color','#12C974');
        $(".order-type span").css('border-bottom','none');
        $(".order-type span").eq(1).css('border-bottom','1px solid #12C974');

    }
        //显示待收货
    function orderSent(){
        $(".order-hidden").css('display','none');
        $("#orderSent").show();
        $(".order-type span").css('color','#6F6F6F');
        $(".order-type span").eq(2).css('color','#12C974');
        $(".order-type span").css('border-bottom','none');
        $(".order-type span").eq(2).css('border-bottom','1px solid #12C974');

    }
        //显示待评价
    function orderReceived(){
        $(".order-hidden").css('display','none');
        $("#orderReceived").show();
        $(".order-type span").css('color','#6F6F6F');
        $(".order-type span").eq(3).css('color','#12C974');
        $(".order-type span").css('border-bottom','none');
        $(".order-type span").eq(3).css('border-bottom','1px solid #12C974');

    }
        //显示已取消
    function orderCancelled(){
        $(".order-hidden").css('display','none');
        $("#orderCancelled").show();
        $(".order-type span").css('color','#6F6F6F');
        $(".order-type span").eq(4).css('color','#12C974');
        $(".order-type span").css('border-bottom','none');
        $(".order-type span").eq(4).css('border-bottom','1px solid #12C974');

    }
    /** 所有订单 **/
        //付款
        function pay(id){
            window.location.href = ""+id;
        }
        //评价
        function evaluate(id){
            window.location.href = "user/orders/close/"+id;
        }
        //收货
        function sent(id){
            if(confirm("确认要收货？")){ 
                window.location.href = "user/orders/close/"+id;
            } 
        }
        //取消订单
        function clears(id){
            if(confirm("确认要取消该订单？")){ 
                window.location.href = "user/orders/cancel/"+id;
            } 
        }
        //订单号搜索
        function searchs(){
            var val = $("#search").val();
            if (val!="") {
                window.location.href = "user/orders?search="+val;
            }else{
                alert('请输入订单号！');
            }
        }

        //删除订单
        function deleteOrder(id){
            if(confirm("是否要删除该订单？")){ 
                window.location.href = "user/orders/delete/"+id;
            }  
        }

    </script>
@show

