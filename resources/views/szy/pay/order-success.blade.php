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
            <p style="font-size:18px;text-align: center;">购买成功，请耐心等候发货</p>
        </div>
    </div>
@stop {{-- end content --}}

@section('scripts')
@show
