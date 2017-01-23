@extends('szy.layouts.orders-pay-app')

@section('title')
我家菜市 - 订单支付
@stop

@section('css')
    {!! Html::style('/css/szy/pay.css') !!}
@stop

@section('content')
    <div class="success-tips">
        <div class="top">
            <div class="left">
                <em>订单提交成功，请您尽快付款！订单号:</em>
                <span>20393789250</span>
            </div>
            <div class="right">
                <em>应付金额:</em>
                <span>￥39.90</span>
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
    <div class="pay-main">
        <div class="pay-way">
            <div class="pay-left">
                <img src="images/chk.png" alt="" class="chk">
                <img src="images/gs_logo.png" alt="" class="gs">
                <span class="card">中国工商银行</span>
                <span class="shortcut">快捷</span>
                <em>储蓄卡(2068)</em>
            </div>
            <div class="pay-right">
                <em>支付</em>
                <span>￥39.90</span>
                <em>元</em>
            </div>
        </div>
        <div class="other-way">
            <a href="#">其他付款方式</a>
            <a href="#">添加快捷/网银付款</a>
        </div>
        <div class="psd-inner">
            <div class="safe-tip">
                <img src="images/pay_s.png" alt="">
                <em>你在安全的环境中，请放心使用！</em>
            </div>
            <div class="psd-title">请输入密码:</div>
            <div class="psd">
                <div class="box"></div>
                <div class="forget"><a href="">忘记密码？</a></div>
                <div class="errorPoint">请输入数字！</div>
            </div>
        </div>
        <div class="sure-pay">
            <a href="#">确定支付</a>
        </div>
    </div>
@stop {{-- end content --}}

@section('scripts')
    @parent
    <script type="text/javascript">

        $(function () {
            var totalHeight = $(window).height();
            colHeight = totalHeight-241;
            payMainHeight = colHeight+"px";
            console.log(payMainHeight);

            var payMain = $('.pay-main');
            payMain.css("height",payMainHeight);

            var box = $('.box');
            function createDIV(num){
                for(var i = 0;i < num;i++){
                    var pawDiv = $('<div class="pawDiv"></div>');
                    box.append(pawDiv);
                    var bod = $('<div class="bod"></div>');
                    pawDiv.append(bod);
                    var paw = $('<input class="paw" type="password" maxLength="1" readOnly="readonly"/>');
                    bod.append(paw);
                }
            }
            createDIV(6) ;

            var pawDiv = $('.pawDiv');
            var paw = $('.paw');
            var pawDivCount = pawDiv.length;

            /*设置第一个输入框默认选中*/
            pawDiv[0].setAttribute("style","border: 2px solid #17adec;");
            paw[0].readOnly = false;
            paw[0].focus();

            var errorPoint = $('.errorPoint')[0];

            /*绑定pawDiv点击事件*/
            function func () {
                for (var i = 0;i < pawDivCount;i++) {
                    pawDiv[i].addEventListener("click",function(){
                        pawDivClick(this);
                    });
                    paw[i].onkeyup = function(event){
                        console.log(event.keyCode);
                        if(event.keyCode >= 48&&event.keyCode <= 57 || event.keyCode >= 96 && event.keyCode <= 105){
                            /*输入0-9*/
                            changeDiv();

                        }else if(event.keyCode == "8") {
                            /*退格回删事件*/
                            firstDiv();

                        }else if(event.keyCode == "13"){
                            /*回车事件*/
                            getPassword();

                        }else{
                            /*输入非0-9*/
                            errorPoint.setAttribute("style","display:block;")
                        }

                    };

                }
            }
            func();


            /*定义pawDiv点击事件*/
            var pawDivClick = function (e) {
                for(var i = 0;i < pawDivCount;i++){
                    pawDiv[i].setAttribute("style","border:none");
                }
                e.setAttribute("style","border: 2px solid deepskyblue;");
            };

            /*定义自动选中下一个输入框事件*/
            var changeDiv = function () {
                // console.log('in');
                for(var i = 0;i < pawDivCount-1;i++){
                    if(paw[i].value.length == "1"){
                        /*处理当前输入框*/
                        paw[i].blur();

                        /*处理上一个输入框*/
                        paw[i+1].focus();
                        paw[i+1].readOnly = false;
                        pawDivClick(pawDiv[i+1]);
                    }
                }
            };

            /*回删时选中上一个输入框事件*/
            var firstDiv = function () {
                for(var i = 0;i < pawDivCount;i++){
                    // console.log(i);
                    if(paw[i].value.length == "0"){
                        /*处理当前输入框*/
                        // console.log(i);
                        paw[i].blur();

                        /*处理上一个输入框*/
                        paw[i-1].focus();
                        paw[i-1].readOnly = false;
                        paw[i-1].value = "";
                        pawDivClick(pawDiv[i-1]);
                        break;
                    }
                }
            };

        })
    </script>
@show
