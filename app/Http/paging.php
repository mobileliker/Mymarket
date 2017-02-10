<?php

/*
 v1.0 
 功能：paging分页工具类
 作者：guosenlin
 日期：2016/8/22

 v1.1
 功能：paging分页工具类
 作者：苏锐佳
 日期：2016/09/05
 描述：修改$link变量在为''时的值为请求的uri+参数
*/

namespace App\Http;

use Illuminate\Support\Facades\Auth;
class Paging
{

    //  $name   //数据对象名称
    //  $module //路由的module名称
    //  $data   //数据资源

    static public function pagin($module, $name, $data = array(),$input = array())
    {

        $uri = 'c' . '/' . $module . '/query';
        $data->setPath($uri);//设置url

        $page = 1;//默认为第一页
        //判断是否获取page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }
        //遍历数组对象 添加序号order
        foreach ($data as $key => $value) {
            $data[$key]->order = ($page - 1) * config('app.page_size') + $key + 1;
            $data[$key]->image = explode(',', $data[$key]->image);
        }

        $links = $data->appends($input)->links();

        if ($links != '') {
            $links = $links->toHtml();
        } else {
            if(!empty($input)){     //排除传给$input的值为null的情况
                foreach ($input as $key => $param) {
                    $links .= $key . '=' . $param . '&';
                }
            }

            $links = '/' . $uri . '?' . $links;
            $links = substr($links, 0, strlen($links) - 1);
        }

        return response()->json([
            $name => $data,
            'links' => $links
        ]);
    }
}

?>