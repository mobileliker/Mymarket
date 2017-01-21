@extends('layouts.wpanel')
@section('title')@parent- 内容管理 @stop
@section('panel_left_content')
    @parent
@stop
@section('center_content')
    <div class="container-fluid">
        <div class="row">
            @include('partial.message')
            <div class="panel panel-default" ng-controller = "ProfileController" >
                <div class="panel-heading">
                    <h6><span class="glyphicon glyphicon-cog"></span> 内容管理
                        <a href="wpanel/articles/create" class="btn btn-default btn-md pull-right btn-szyclass">新 建</a>
                    </h6>
                </div>
                <div class="panel-body" style="min-height:500px;">
                    <ul class="nav nav-tabs" >
                        <li class="active" style="float:left"><a data-toggle="tab" href="#profile">文章管理</a></li>
                    </ul>

                    <div class="panel-body" style="min-height:500px;">
                        {{--<input type="search" ng-model="search" class="form-control" placeholder="{{ trans('globals.search_for').' '.trans('product.inputs_view.name') }}"/> --}}
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-info hidden-xs">
                                <div class="row">
                                    <div class="col-md-1">#ID</div>
                                    <div class="col-md-3">标题</div>
                                    <div class="col-md-3">slug</div>
                                    <div class="col-md-2">分类</div>
                                    <div class="col-md-1">排序</div>
                                    <div class="col-md-2">操作</div>
                                </div>
                            </li>
                            @foreach($articles as $article)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-1">{{ $article->id }}</div>
                                        <div class="col-md-3"><a href="{{ route('wpanel.articles.show',$article->id) }}">{{ $article->title }}</a></div>
                                        <div class="col-md-3">{{$article->slug}}</div>
                                        @if($article->category_id != null)
                                            <div class="col-md-2">{{$article->category->display_name}}</div>
                                        @else
                                            <div class="col-md-2">单页面</div>
                                        @endif
                                        <div class="col-md-1">{{$article->sort}}</div>
                                        <div class="col-md-2">
                                            <a href="wpanel/articles/{{ $article->id }}/edit">编辑</a>
                                            |
                                            <form class="form-operate-delete" id="delete_form_{{$article->id}}"action="{{url('wpanel/articles/'.$article->id)}}" method="POST" style="display:inline;">
                                                {!!csrf_field()  !!}
                                                <input name="_method" type="hidden" value="DELETE">
                                                <a href="javascript:delete_form_{{$article->id}}.submit();">删除</a>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div>{{$articles->links()}}</div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    @parent
@stop
