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
            <p style="font-size:18px;text-align: center;">你已提交过订单，请勿重复提交订单</p>
        </div>
    </div>
@stop {{-- end content --}}

@section('scripts')
@show
