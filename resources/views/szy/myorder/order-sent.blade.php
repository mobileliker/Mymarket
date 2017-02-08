@if(isset($sentOrders[0]))
    @foreach($sentOrders as $openOrder)
    <div class="details">
        <div class="date">
            <span>{{$openOrder->created_at}}</span>
            <span>订单编号: <a href="user/orders/show/{{$openOrder->id}}">{{$openOrder->order_number}}</a></span>
            <span>
                <?php 
                    $role = App\User::find($openOrder->seller_id)->role;
                ?>
                @if($role!='admin')
                    @if($orderType=='myorder')
                    <a href="shop/{{$openOrder->seller_id}}">
                    <?php echo App\Business::where('user_id',$openOrder->seller_id)->first()->business_name; ?>
                    </a>
                    @else
                    购买用户:<?php echo App\User::find($openOrder->user_id)->nickname; ?>
                    @endif
                @else
                    平台自营
                @endif
            </span>
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
            @if($openOrder->status=='sent')已发货 @endif
            <br>
            <a href="user/orders/show/{{$openOrder->id}},{{$orderType}}">订单详情</a>
        </div>
        <div class="user">
            <?php echo App\Address::where('id',$openOrder->address_id)->first()->name_contact; ?>
            <span class="glyphicon glyphicon-user"></span>
        </div>
            
        <div class="price">总额 ￥{{$priceCount}} <br> 微信支付</div>
        <div class="operate">
            <?php 
                if ($openOrder->status=='sent') {
                    $delivery = App\Delivery::where('order_id',$openOrder->id)->first();
                    $deliveryTime = strtotime($delivery->created_at);
                    $countTime = $deliveryTime + 15*24*3600;
                    $syTime = $countTime - time();
                    $day = intval($syTime/(24*3600));
                    $h = intval($syTime%(24*3600)/3600);
                }
            ?>
            @if($openOrder->status=='sent')
                <span>还剩{{$day}}天{{$h}}小时</span>
            @endif
            
            <br>
            <br>
            <button onclick="sent({{$openOrder->id}});">收货</button>
        </div>
    </div>
    @endforeach
@else
    <div class="null">
        没有相关订单信息！
    </div>
@endif
