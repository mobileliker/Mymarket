@extends('szy.layouts.orders-pay-app')

@section('title')
微信安全支付
@stop

@section('css')
    {!! Html::style('/css/szy/pay.css') !!}
@stop

@section('content')
    <div class="success-tips">
        <div class="top">
            <div class="left">
                <em>订单提交成功，请您尽快付款！订单号:</em>
                <span>{{$order_number}}</span>
            </div>
            <div class="right">
                <em>应付金额:</em>
                <span>￥{{$count}}</span>
            </div>
        </div>
        <div class="btm">
            <div class="left">
                <span>请您在提交订单<em>24小时</em>内完成支付，否则订单会自动取消。</span>
            </div>
            <div class="right">
                <span>订单详情<em></em></span>
            </div>  
        </div>
    </div>
    <div class="pay-main" style="height:550px;">
        <center>
        <div style="width:70%;height:60%;background-color:#FFFFFF;margin-top:50px;">
            <div style="width:100%;height:70px;border-bottom: 1px solid #ccc;margin-bottom:20px;"><img src="img/szy/inc/wx_pay.png"></div>
            <p style="font-size:20px;">打开手机微信，扫一扫下面二维码，即可完成支付<p>
            <div align="center" id="qrcode" style="margin-top:20px;">
            </div>
        </div>
        </center>
    </div>
<?php
    include_once str_replace("\\","/",public_path())."/WPay/WxPayPubHelper/WxPayPubHelper.php";
    //使用统一支付接口
    $unifiedOrder = new UnifiedOrder_pub();
    $unifiedOrder->setParameter("body","贡献一分钱"); //商品描述
    //自定义订单号，此处仅作举例
    $timeStamp = time();
    $out_trade_no = WxPayConf_pub::APPID."$timeStamp"; 
    $unifiedOrder->setParameter("out_trade_no",$order_number);//商户订单号 
    $unifiedOrder->setParameter("total_fee",'1');//总金额
    $unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址 
    $unifiedOrder->setParameter("trade_type","NATIVE");//交易类型
    $unifiedOrder->setParameter("sub_mch_id","1444913102");//交易类型
    //获取统一支付接口结果
    $unifiedOrderResult = $unifiedOrder->getResult();
    //商户根据实际情况设置相应的处理流程
    if ($unifiedOrderResult["return_code"] == "FAIL") 
    {
        //商户自行增加处理流程
        echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
    }
    elseif($unifiedOrderResult["result_code"] == "FAIL")
    {
        //商户自行增加处理流程
        echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
        echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
    }
    elseif($unifiedOrderResult["code_url"] != NULL)
    {
        //从统一支付接口获取到code_url
        $code_url = $unifiedOrderResult["code_url"];
        //商户自行增加处理流程
        //......
    }
?>
@stop {{-- end content --}}

@section('scripts')
    @parent
    <script src="{{asset('WPay/demo/qrcode.js')}}"></script>
    <script src='/js/szy/jquery1.42.min.js'></script>
    <script>
    if(<?php echo $unifiedOrderResult["code_url"] != NULL; ?>)
    {
        var url = "<?php echo $code_url;?>";
        //参数1表示图像大小，取值范围1-10；参数2表示质量，取值范围'L','M','Q','H'
        var qr = qrcode(10, 'M');
        qr.addData(url);
        qr.make();
        var wording=document.createElement('p');
        var code=document.createElement('DIV');
        code.innerHTML = qr.createImgTag();
        var element=document.getElementById("qrcode");
        element.appendChild(wording);
        element.appendChild(code);
    }
    </script>
    <script>
        setInterval("ajaxstatus()",3000);//1000为1秒钟
        function ajaxstatus() {
            $.ajax({
                type: "get",
                url: "http://www.caishi360.com/user/orders/getNumberState",//文件路由
                data: {
                    "order_number":"<?php echo $order_number?>"
                },
                dataType: "json",//json等等
                success: function (data) {
                    console.log(data);
                    if(data.status=='paid') {
                        window.location.href="http://www.caishi360.com/user/orders/pay/successful">;
                    }
                }
            });
        } 
    </script>
@show
