@if(isset($unRate[0]))
    @foreach($unRate as $openOrder)
    <div class="details">
        <div class="date">
            <span>{{$openOrder->created_at}}</span>
            <span>订单编号: <a href="user/orders/show/{{$openOrder->id}}">{{$openOrder->seller_id}}</a></span>
            <span><a href="shop/{{$openOrder->seller_id}}"><?php echo App\Business::where('user_id',$openOrder->seller_id)->first()->business_name; ?></a></span>
            <a href="javascript:void(0);" class="glyphicon glyphicon-trash delete"></a>
        </div>
        <?php 
            $orderProducts = App\OrderDetail::where('order_id',$openOrder->id)
                            ->join('products','order_details.product_id','=','products.id')
                            ->select('products.name as product_name','products.features','products.id as pid','order_details.*')
                            ->get();
            $priceCount = 0;
            foreach ($orderProducts as $product) {
                $priceCount = $priceCount + $product->price; 
            }
        ?>

        <div class="product"> 
            @if(!empty($orderProducts))  
            @foreach($orderProducts as $orderProduct)
            <li>
                <div class="p-details">
                    <img src="{{json_decode($orderProduct->features)->{'images'}[0]}}">
                    <div class="p-t">
                        <a href="products/{{$orderProduct->pid}}">{{$orderProduct->product_name}} </a>
                    </div>
                    <div class="amount">× {{$orderProduct->quantity}} </div>
                    <div class="p-gg">
                        @foreach(json_decode($orderProducts[0]->features) as $name=>$value)
                            @if($name!='images' && $value!=null)
                            {{$name}}:{{$value}}&nbsp;
                            @endif
                        @endforeach
                    </div>
                    
                </div>
            </li>
            @endforeach
            @endif
        </div>
        <div class="business">
            @if($openOrder->status=='cancelled')已取消 @endif
            @if($openOrder->status=='sent')已发货 @endif
            @if($openOrder->status=='paid')已付款 @endif
            @if($openOrder->status=='open')待付款 @endif
            @if($openOrder->status=='pending')待处理 @endif
            @if($openOrder->status=='received')待评价 @endif
            @if($openOrder->status=='closed')已完成 @endif
            <br>
            <a href="user/orders/show/{{$openOrder->id}}">订单详情</a>
        </div>
        <div class="user">
            <?php echo App\Address::where('id',$openOrder->address_id)->first()->name_contact; ?>
            <span class="glyphicon glyphicon-user"></span>
        </div>
            
        <div class="price">总额 ￥{{$priceCount}} <br> 微信支付</div>
        <div class="operate">
            <?php 
                $delivery = App\Delivery::where('order_id',$openOrder->id)->first();
                $deliveryTime = strtotime($delivery->created_at);
                $countTime = $deliveryTime + 15*24*3600;
                $syTime = $countTime - time();
                $day = intval($syTime/(24*3600));
                $h = intval($syTime%(24*3600)/3600);
            ?>
            <span>还剩{{$day}}天{{$h}}小时</span>
            <br>
            <br>
            @if($openOrder->status=='cancelled' || $openOrder->status=='open')
                <button onclick="pay({{$openOrder->id}});">付款</button>
            @endif
            @if($openOrder->status=='received')
                <button onclick="evaluate({{$openOrder->id}});">评价</button>
            @endif
            @if($openOrder->status=='sent')
                <button onclick="sent({{$openOrder->id}});">收货</button>
            @endif
            @if($openOrder->status=='pending' || $openOrder->status=='paid' || $openOrder->status=='open')
                <button onclick="clears({{$openOrder->id}});">取消订单</button>
            @endif
        </div>
    </div>
    @endforeach
@else
    <div class="null">
        没有相关订单信息！
    </div>
@endif
