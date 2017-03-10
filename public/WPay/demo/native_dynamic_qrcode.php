<?php
/**
 * Native（原生）支付-模式二-demo
 * ====================================================
 * 商户生成订单，先调用统一支付接口获取到code_url，
 * 此URL直接生成二维码，用户扫码后调起支付。
 * 
*/
	include_once("../WxPayPubHelper/WxPayPubHelper.php");

	//使用统一支付接口
	$unifiedOrder = new UnifiedOrder_pub();

	$unifiedOrder->setParameter("body","贡献一分钱");//商品描述
	//自定义订单号，此处仅作举例
	$timeStamp = time();
	$out_trade_no = WxPayConf_pub::APPID."$timeStamp";
	$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
	$unifiedOrder->setParameter("total_fee","1");//总金额
	$unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址 
	$unifiedOrder->setParameter("trade_type","NATIVE");//交易类型
	//非必填参数，商户可根据实际情况选填
	$unifiedOrder->setParameter("sub_mch_id","1444913102");//子商户号 
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


<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>微信安全支付</title>
</head>
<body>
	<div align="center" id="qrcode">
	</div>
</body>
	<script src="./qrcode.js"></script>
	<script>
            if(<?php echo $unifiedOrderResult["code_url"] != NULL; ?>)
            {
                    var url = "<?php echo $code_url;?>";
                    //参数1表示图像大小，取值范围1-10；参数2表示质量，取值范围'L','M','Q','H'
                    var qr = qrcode(10, 'M');
                    qr.addData(url);
                    qr.make();
                    var wording=document.createElement('p');
                    wording.innerHTML = "扫我，扫我";
                    var code=document.createElement('DIV');
                    code.innerHTML = qr.createImgTag();
                    var element=document.getElementById("qrcode");
                    element.appendChild(wording);
                    element.appendChild(code);
            }
//            function ajaxstatus() {
//                $.post("http://www.caishi360.com/WPay/demo/notify_url",{orderid:<?php echo $order_id?>},function(data)) {
//                    if(data.status==1) {
//                        window.location.href='';
//                    }
//                }
//            }
//            setInterval('ajaxstatus()',3000);
	</script>
</html>