<?php
/**
 * 通用通知接口demo
 * ====================================================
 * 支付完成后，微信会把相关支付和用户信息发送到商户设定的通知URL，
 * 商户接收回调信息后，根据需要设定相应的处理流程。
 * 
 * 这里举例使用log文件形式记录回调信息。
*/
	include_once("../WxPayPubHelper/WxPayPubHelper.php");
        //使用通用通知接口
	$notify = new Notify_pub();
	//存储微信的回调
        $xml = file_get_contents("php://input");
	$notify->saveData($xml);
        $conn = mysqli_connect('119.29.34.160','szymm','szymm123456SZYMM','szymm');
	//验证签名，并回应微信。
	//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
	//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
	//尽可能提高通知的成功率，但微信不保证通知最终能成功。
	if($notify->checkSign() == FALSE){
		$notify->setReturnParameter("return_code","FAIL");//返回状态码
		$notify->setReturnParameter("return_msg","签名失败");//返回信息
	}else{
		$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
	}
	$returnXml = $notify->returnXml();
	echo $returnXml;
	
	//==商户根据实际情况设置相应的处理流程，此处仅作举例=======
	
	//以log文件形式记录回调信息
        setlog('./aa.txt',"【接收到的notify通知】:\n".$xml."\n");
	if($notify->checkSign() == TRUE)
	{
            if ($notify->data["return_code"] == "FAIL") {
                    //此处应该更新一下订单状态，商户自行增删操作
                    setlog('./aa.txt',"【通信出错】:\n".$xml."\n");
            }
            elseif($notify->data["result_code"] == "FAIL"){
                    //此处应该更新一下订单状态，商户自行增删操作
                    setlog('./aa.txt',"【业务出错】:\n".$xml."\n");
            }
            else{
                //此处应该更新一下订单状态，商户自行增删操作
                $xml = $notify->xmlToArray($xml);
                setlog('./aa.txt',"【支付成功】:\n".$xml."\n");
                $out_trade_no = $xml['out_trade_no'];
                //修改订单号
                $sql = "update szymm_orders set status='paid' where order_number='$out_trade_no'";
                mysqli_query($conn,$sql);
            }
	}
        
        function setlog($file,$word) {
            $handle=fopen($file,"a+");
            flock($handle, LOCK_EX);
            $str=fwrite($handle,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n");
            flock($handle, LOCK_UN);
            fclose($handle); 
        }
?>