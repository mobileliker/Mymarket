<?php

namespace App\Observers;

use App\OrderDetail;
use App\Product;

class OrderDetailsObserver
{
    public function saved(OrderDetail $orderDetails)
    {
        $detailProducts = OrderDetail::where('order_details.product_id','=',$orderDetails->product_id)  
				        ->whereIn('orders.status',array('received','closed'))
				        ->where('order_details.status','=',1)
				        ->where('orders.type','=','order')
				        ->join('orders','order_details.order_id','=','orders.id')
				        ->select('orders.sever_rate','orders.delivery_rate','order_details.rate')
				        ->get();

        if (!empty($detailProducts) && isset($detailProducts[0])) {

            $count = count($detailProducts);
            $countSeverRate = 0;
            $countDeliveryRate = 0;
            $countProductRate = 0;

            foreach ($detailProducts as $detailProduct) {
                $countSeverRate += $detailProduct->sever_rate;
                $countDeliveryRate += $detailProduct->delivery_rate;
                $countProductRate += $detailProduct->rate;
            }

            $severRateMean = round($countSeverRate/$count,1);  //服务平均分
            $deliveryRateMean = round($countDeliveryRate/$count,1); //物流平均分
            $productRateMean = round($countProductRate/$count,1); //商品平均分

            //总平均分
            $countRateMean = round(($severRateMean+$deliveryRateMean+$productRateMean)/3,1);

            $product = Product::find($orderDetails->product_id);
            $product->sever_rate = $severRateMean;
            $product->delivery_rate = $deliveryRateMean;
            $product->product_rate = $productRateMean;
            $product->count_rate = $countRateMean;
            $product->save();
        }
    }

    public function deleted(OrderDetail $orderDetails){

    }
}