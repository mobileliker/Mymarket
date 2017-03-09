<script src='/js/szy/jquery1.42.min.js'></script>
<script>
      setInterval("myInterval()",1000);//1000为1秒钟
       function myInterval()
       {
            $.ajax({
                type: "get",
                url: "http://www.caishi360.com/user/orders/getNumberState",//文件路由
                data: {
                    'order_number':"wjcs711703095137"
                },
                dataType: "json",//json等等
                success: function (data) {
                    console.log(data);
                }
            });
        }
 </script>