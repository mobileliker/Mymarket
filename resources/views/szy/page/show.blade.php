@extends('szy.layouts.master')

@section('title')
    我家菜市 - {{$article->title}}
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12" style="margin:20px;">
                {!! $article->content !!}
            </div>
        </div>
    </div>
@endsection