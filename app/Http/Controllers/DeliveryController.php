<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Redirect;
use App\Order,App\Delivery;

class DeliveryController extends Controller
{
    public function storeOrUpdate(Request $request, $id)
    {
        $delivery = Delivery::firstOrNew(['order_id' => $id]);

        $delivery_type = $request->get('delivery_type');
        $delivery_name = $request->get('delivery_name');
        $delivery_number = $request->get('delivery_number');

        $delivery->delivery_type = $delivery_type;
        if($delivery->delivery_type != null && $delivery->delivery_type != ''){
            $delivery->delivery_name = $delivery_name;
            $delivery->delivery_number = $delivery_number;
        }
        
        if($delivery->save()){
            $order = Order::find($id);
            $order->status = 'sent';
            if($order->save()){
                Session::push('message', trans('保存发货信息成功'));
                return Redirect::back();
            }
        }
        Session::push('message', trans('保存发货信息失败'));
        return Redirect::back();

    }
}
