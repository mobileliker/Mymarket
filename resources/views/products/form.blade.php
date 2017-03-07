@extends('layouts.master')
@section('title')@parent - @if ($product['id'] == '')

                            {{ trans('product.form_create_title') }}
                            
                            @else

                            {{ str_replace('[prod]', '"'.$product->name.'"', trans('product.form_edit_title')) }}

                            @endif
@stop
@section('page_class') products-create @stop
@section('content')
    @parent
    @section('panel_left_content')
        @include('user.partial.menu_dashboard')
    @stop
    @section('center_content')

        <div class="page-header">
            <h5>
                @if (isset($product['id']))
                    {{ trans('product.form_edit_title', [ 'prod' => $product->name ]) }}
                @else
                    {{ trans('product.form_create_title') }}
                @endif
            </h5>
        </div>
    
        @if(isset($product['id']))
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group pull-right">
                        <button ng-controller="ModalCtrl"
                                ng-click="modalOpen({templateUrl:'productsGroup/{{$product['id']}}/edit',controller:'ModalCtrl', noCache:true})" class="btn btn-sm btn-info">
                        <span class="glyphicon glyphicon-link"></span>&nbsp;
                        {{ trans('product.product_group') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="row">&nbsp;</div>
        <div class="row">
        <div class="col-md-12">
            
            @include('partial.message')

            @if(!$edit)
                
                {!! Form::model(Request::all(),['url'=>'products', 'class'=>'form-horizontal', 'role'=>'form','enctype'=>'multipart/form-data']) !!}
            @else
                    {{-- {{dd($product)}}            --}}
                {!! Form::model($product,['route'=>['products.update',$product],'method'=>'PUT','class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data']) !!}
            @endif
            <style type="text/css">
                .congshu{width:210px;height:30px;border:none;outline:none;}
            </style>
                <div  ng-class="defaultClass">
        
                    <div class="form-group" >
                        <div class="col-sm-3">
                            {!! Form::label('status',trans('globals.status')) !!}:&nbsp;
                            {!! Form::select('status',[1=>trans('globals.active'),0=>trans('globals.inactive')],null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::label('condition',trans('product.inputs_view.condition')) !!}:&nbsp;
                            {!! Form::select('condition',$condition,null,['class'=>'form-control',$disabled=>$disabled]) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::label('category_id',trans('product.globals.categories')) !!}:&nbsp;
                            {!! Form::select('category_id',$categories,null,['class'=>'form-control',$disabled=>$disabled,'required']) !!}
                        </div>
                         @if(!$product)
                        <div class="col-sm-3" ng-init="typeItem='{{ $typeItem }}'">
                            {!! Form::label('type',trans('globals.type')) !!}:&nbsp;
                            {!! Form::select('type',$typesProduct,$typeItem,['class'=>'form-control','ng-model="typeItem"']) !!}
                        </div>
                        @else
                            {!! Form::hidden('type',$typeItem) !!}
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6">
                            {!! Form::label('name',trans('product.inputs_view.name')) !!}:&nbsp;
                            {!! Form::text('name',null,['class'=>'form-control','required']) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::label('name','从属商品') !!}:&nbsp;
                            <div class='form-control'>

                            <input  type="text" class="congshu">
                            <select  class="congshu" name="products_group">
                                <option value="false">不从属</option>
                                @if(isset($product->name))
                                    @if($product->id != $product->products_group)
                                        @foreach($cs as $pt)
                                        <option value="{{$pt->products_group}}" @if($pt->products_group == $product->products_group) selected=true @endif>{{$pt->name}}</option>
                                        @endforeach
                                    @endif
                                @else
                                    @foreach($cs as $pt)
                                    <option value="{{$pt->products_group}}">{{$pt->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            {!! Form::label('description',trans('product.inputs_view.description')) !!}:&nbsp;
                            {!! Form::textarea('description',null,['class'=>'form-control','rows'=>'2','required']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-4">
                            {!! Form::label('brand',trans('product.inputs_view.brand')) !!}:&nbsp;
                            {!! Form::text('brand',null,['class'=>'form-control','required']) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label('price_raw','原价') !!}:&nbsp;
                            {!! Form::text('price_raw',null,['class'=>'form-control','required']) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label('price','现价') !!}:&nbsp;
                            {!! Form::text('price',null,['class'=>'form-control','required']) !!}
                        </div>
                    </div>

                    <div class="form-group ng-cloak" >
                        <div class="col-sm-4">
                            {!! Form::label('stock',trans('product.globals.stock')) !!}:&nbsp;
                            {!! Form::number('stock',null,['class'=>'form-control','required']) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label('low_stock','低库存') !!}:&nbsp;
                            {!! Form::number('low_stock',null,['class'=>'form-control','required']) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label('bar_code',trans('product.inputs_view.bar_code')) !!}:&nbsp;
                            {!! Form::text('bar_code',null,['class'=>'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group ng-cloak" >
                        <div class="col-sm-4">
                            {!! Form::label('origin','产地') !!}:&nbsp;
                            @if(isset($product->origin))
                            {!! Form::text('origin',$product->origin,['class'=>'form-control','required']) !!}
                            @else 
                            {!! Form::text('origin',null,['class'=>'form-control','required']) !!}
                            @endif
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label('plan_date','生产日期') !!}:&nbsp;
                            @if(isset($product->plan_date))
                            {!! Form::text('plan_date',$product->plan_date,['class'=>'form-control','required']) !!}
                            @else 
                            {!! Form::text('plan_date',null,['class'=>'form-control','required']) !!}
                            @endif
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label('quality_time','保质期') !!}:&nbsp;
                            @if(isset($product->quality_time))
                            {!! Form::number('quality_time',$product->quality_time,['class'=>'form-control','required']) !!}
                            @else
                            {!! Form::number('quality_time',90,['class'=>'form-control','required']) !!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group ng-cloak" >
                        <div class="col-sm-4">
                            {!! Form::label('pack','包装') !!}:&nbsp;
                            @if(isset($product->pack))
                            {!! Form::text('pack',$product->pack,['class'=>'form-control','required']) !!}
                            @else
                            {!! Form::text('pack',null,['class'=>'form-control','required']) !!}
                            @endif
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label('import','进口/国产') !!}:&nbsp;

                            <select name="import" class="form-control">
                            @if(isset($product->pack))
                                <option value=0 @if($product->pack==0)selected=true @endif>国产</option>
                                <option value=1 @if($product->pack==1)selected=true @endif>进口</option>
                            @else
                                <option value=0>国产</option>
                                <option value=1>进口</option>
                            @endif
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="control-label">二维码:</label>
                        </div>
                        <div class="col-md-3">
                            <input class='upload-pic' type="file" id="pic_code" name="code" style="display:none">
                            @if(isset($product->code) && !empty($product->code))
                            <img src="{{$product->code}}" alt="点击" class="thumbnail" onclick="$('input[id=pic_code]').click();" width="90px" height="80px" style="cursor:pointer">
                            @else
                            <img src="img/no-img.png" alt="点击" class="thumbnail" onclick="$('input[id=pic_code]').click();" width="90px" height="80px" style="cursor:pointer">
                            @endif
                        </div>
                    </div>

                    <div class="form-group ng-cloak" >
                       <div class="col-sm-6">
                            {!! Form::label('delivery_price','邮寄费 | 除港澳台 | 0为包邮') !!}:&nbsp;
                            @if(isset($product->delivery_price))
                            {!! Form::text('delivery_price',$product->delivery_price,['class'=>'form-control','required']) !!}
                            @else 
                            {!! Form::text('delivery_price',0,['class'=>'form-control','required']) !!}
                            @endif
                        </div>
                        <div class="col-sm-6">
                            {!! Form::label('delivery_price_except','港澳台邮寄费 | 0为包邮') !!}:&nbsp;
                            @if(isset($product->delivery_price_except))
                            {!! Form::text('delivery_price_except',$product->delivery_price_except,['class'=>'form-control','required']) !!}
                            @else 
                            {!! Form::text('delivery_price_except',0,['class'=>'form-control','required']) !!}
                            @endif
                        </div>
                    </div>
                    <div class="form-group ng-cloak" ng-show="typeItem=='key'">
                        <div class="col-sm-2 col-sm-offset-4">
                            <div ng-controller="upload" ng-init="file='{{ (Input::old('key')?Input::old('key'):'') }}'">
                                <button class="form-control col-sm-2" ng-file-select ng-model="files" accept=".txt" type="button" ng-click="type_file='key'" ng-class="successClass">{{ trans('globals.file') }}
                                <input type="hidden" value="[[file]]" name="key">
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <a href="/products/downloadExample" class="form-control" target="_blank">{{ trans('product.inputs_view.download_example') }}</a>
                        </div>
                        @if($product)
                        <div class="col-sm-5 col-sm-offset-4">
                            <button ng-controller="ModalCtrl" ng-init="data={'data':{{ $product->id }}}" ng-click="modalOpen({templateUrl:'/modalAllKeys',controller:'getKeysVirtualProducts',resolve:'data'})" class="btn btn-block btn-warning col-sm-12" type="button" style="margin-top:10px;">{{ trans('product.globals.see_keys') }}</button>
                        </div>
                        @endif
                        <div class="col-sm-8 col-sm-offset-4"><small>{!! trans('product.inputs_view.key_option') !!}</small> </div>
                    </div>

                    <div class="form-group ng-cloak" ng-show="typeItem=='software'">
                        <div class="col-sm-4 col-sm-offset-4">
                            <div ng-controller="upload" ng-init="file='{{ (Input::old('software')?Input::old('software'):'') }}'">
                            <button class="form-control col-sm-2" ng-file-select ng-model="files" accept=".rar,.zip" type="button" ng-click="type_file='software'" ng-class="successClass">{{ trans('globals.file') }}
                                <input type="hidden" value="[[file]]" name="software">
                            </button>
                            </div>
                        </div>
                        <div class="col-sm-8 col-sm-offset-4">{!! trans('product.inputs_view.software_option') !!}</div>
                    </div>

                    <div class="form-group ng-cloak" ng-show="typeItem=='software_key'">
                        <div class="col-sm-6 col-sm-offset-4">
                            <div ng-controller="upload" ng-init="file='{{ (Input::old('software_key')?Input::old('software_key'):'') }}'">
                            <button class="form-control col-sm-2" ng-file-select ng-model="files" accept=".rar,.zip" type="button" ng-click="type_file='software'" ng-class="successClass">{{ trans('globals.file').' '.trans('product.globals.software') }}
                                <input type="hidden" value="[[file]]" name="software_key">
                            </button>
                            </div>
                        </div>
                        <div class="col-sm-12"></div>
                        <div class="col-sm-3 col-sm-offset-4">
                            <div ng-controller="upload" ng-init="file='{{ (Input::old('key_software')?Input::old('key_software'):'') }}'">
                                <button class="form-control col-sm-2" ng-file-select ng-model="files" accept=".txt" type="button" ng-click="type_file='key'" ng-class="successClass">{{ trans('globals.file').' '.trans('product.globals.key') }}
                                <input type="hidden" value="[[file]]" name="key_software">
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <a href="/products/downloadExample" class="form-control" target="_blank">{{ trans('product.inputs_view.download_example') }}</a>
                        </div>
                        <div class="col-sm-8 col-sm-offset-4">{!! trans('product.inputs_view.software_key_option') !!}</div>
                    </div>

                    <div class="form-group" ng-show="typeItem=='gift_card'">
                        <div class="col-sm-6">
                            {!! Form::label('amount',trans('product.inputs_view.amount')) !!}
                            {!! Form::number('amount',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-sm-8 col-sm-offset-4">{!! trans('product.inputs_view.gift_card_option') !!}</div>
                    </div>
                       
                    <h5>{{ trans('product.globals.features') }}</h5>

                    <hr>
               
                    @include('features.makeInputsToDocumentsPicturesVideos',['force'=>false])
                    @include('features.makeInputs',['force'=>false])
                    <div class="col-md-12">
                            <label class="control-label">商品详情介绍:</label>

                    <script id="editor" type="text/plain"  name="desc_img" 
                    style="width:1024px;height:400px;border:1px solid #3DCDB4;">@if(isset($product->desc_img)){!! $product->desc_img !!}@endif</script>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;{{ trans('product.globals.save') }}</button>  
                        <button  type="button" ng-controller="ModalCtrl"
                                ng-click="modalOpen({templateUrl:'productsGroup/{{$product['id']}}/edit',controller:'ModalCtrl', noCache:true})" class="btn btn-sm btn-info">
                        <span class="glyphicon glyphicon-link"></span>&nbsp;
                        {{ trans('product.product_group') }}
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
        </div>

    </div>

    @stop
@stop
@section('scripts')
    @parent
    {!! Html::script('/js/vendor/file-upload/angular-file-upload-shim.min.js') !!}
    {!! Html::script('/js/vendor/file-upload/angular-file-upload.min.js') !!}
    {!! Html::script('/js/vendor/deleted/jquery.min.js') !!}
    {!! Html::script('/ueditor/ueditor.config.js') !!}
    {!! Html::script('/ueditor/ueditor.all.min.js') !!}
    {!! Html::script('/ueditor/lang/zh-cn/zh-cn.js') !!}
    <script>
        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        var ue = UE.getEditor('editor');
        imagePathFormat='/upload/desc_img/'; 

        //图片上传事件
        $(".upload-pic").change(function () {
            uploadPic(this.files[0],$(this));
        });

        function uploadPic(a,b){
            var reader = new FileReader();
            reader.readAsDataURL(a);
            //监听文件读取结束后事件
            reader.onloadend = function (e) {
                $(b).next('img').attr('src',e.target.result);
            };
        };

        (function(app){
            app.controller('upload', ['$scope', '$upload', '$timeout','$http', function ($scope, $upload, $timeout, $http) {
                $scope.$watch('files', function () {
                    $scope.upload($scope.files);
                });

                $scope.file='';
                $scope.type_file='';
                $scope.successClass="";
                $scope.progress='';
                $scope.error='';

                $scope.upload = function (files) {
                    if (files && files.length && ($scope.type_file==''||$scope.type_file=='key'||$scope.type_file=='software')) {
                        for (var i = 0; i < files.length; i++) {
                            var file = files[i];
                            var url='/products/upload'+($scope.type_file!=''?'_'+$scope.type_file:'');
                            $upload.upload({
                                url: url,
                                fields: {"_token":'{{ csrf_token() }}',"_method":"POST"},
                                file: file
                            }).progress(function (evt) {
                                 var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                                 $scope.progress= progressPercentage + '% ';
                            }).success(function (data, status, headers, config) {
                                if(data.indexOf("Error:")> -1){

                                    $scope.progress='';
                                    $scope.error=data;
                                    $timeout(function(){
                                        $scope.error= '';
                                    }, 5000);

                                }else{
                                    old=$scope.file;
                                    $scope.file=data;
                                    $scope.error='';
                                    $timeout(function(){
                                        $scope.progress= '';
                                    }, 1000);

                                    if(old){
                                        $scope.delete(old);
                                    }
                                   
                                }
                                
                            });
                        }
                    }
                };

                $scope.delete = function (old) {
                    file = old || $scope.file;
                    if (file) {

                        $http.post('/products/delete_img',{'file':file}).
                              success( function(data) {
                                    if (parseInt(data)==1 && !old) {
                                        $scope.file='';
                                    }
                                    
                              });
                    }
                };

            }]);
        })(angular.module("AntVel"))
    </script>
@stop
@section('before.angular') ngModules.push('angularFileUpload'); @stop