@extends('layouts.wpanel')
@section('title')@parent- 文章管理 @stop
@section('panel_left_content')
    @parent
@stop
@section('center_content')
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-default" ng-controller = "ProfileController" >
                <div class="panel-heading">
                    <h6><span class="glyphicon glyphicon-cog"></span> 修改文章</h6>
                </div>
                <div class="panel-body" style="min-height:500px;">
                    @if (count($errors) > 0)
                        <div class="alert alert-warning fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                            <strong>{{trans('common.Whoops!')}}</strong>{{trans('common.error-tip')}}<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="col-md-12">
                        {!! Form::open(['url'=>'wpanel/articles/'.$article->id, 'class'=>'form-horizontal','role'=>'form']) !!}
                        <div class="form-group">
                            <div class="col-md-12">
                                {!! Form::label('title','标题') !!}:
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-align-justify"></span></div>
                                    {!! Form::text('title', $article->title, ['ng-disabled'=>'disabled','class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-12">
                                {!! Form::label('category_id','分类') !!}:
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-align-justify"></span></div>
                                    {!! Form::select('category_id',$groupCategories,$article->category_id,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                {!! Form::label('slug','slug') !!}:
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-envelope"></span></div>
                                    {!! Form::text('slug', $article->slug, ['ng-disabled'=>'disabled','class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                {!! Form::label('sort','排序' )!!}:
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-lock"></span></div>
                                    {!! Form::number('sort', $article->sort,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                {!! Form::label('content','内容') !!}:
                                <div class="col-md-12">
                                    <script id="editor" name="content" style="height:400px;border:1px solid #3DCDB4;">{!!$article->content!!}</script>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <hr>
                                <div class="btn-group" role="group">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-send"></span>
                                        &nbsp;保存
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{ Form::hidden('_method', 'PUT') }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop
@section('mm_script')
    @parent
    {!! Html::script('/ueditor/ueditor.config.js') !!}
    {!! Html::script('/ueditor/ueditor.all.min.js') !!}
    {!! Html::script('/ueditor/lang/zh-cn/zh-cn.js') !!}
    <script>
        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        var ue = UE.getEditor('editor');
        imagePathFormat='/upload/desc_img/';
    </script>
@endsection