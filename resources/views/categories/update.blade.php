@extends('layouts.wpanel')
@section('page_class') category-panel @stop
@section('center_content')
	@include('partial.message')
	<div ng-controller="CategoryController" class="panel panel-default">
		<div class="panel-heading"> <span class="glyphicon glyphicon-tasks"></span> {{ trans('categories.update_title') }}</div>
		<div class="panel-body" ng-init="icon='{{ $category->icon }}'">
			{!! Form::model($category,['route'=>['wpanel.category.update',$category],'method'=>'PUT','class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data']) !!}
				<div class="form-group">
					<label class="col-md-4 control-label">{{ trans('globals.name') }}</label>
					<div class="col-md-6">
						{!! Form::text('name',null,['class'=>'form-control']) !!}
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">英文名字</label>
					<div class="col-md-6">
						{!! Form::text('english',null,['class'=>'form-control']) !!}
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">{{ trans('globals.description') }}</label>
					<div class="col-md-6">
						{!! Form::text('description',null,['class'=>'form-control']) !!}
					</div>
				</div>
				{{--
				<div class="row form-group">
					<label class="col-md-4 control-label">{{ trans('globals.image') }}</label>
					<div class="col-md-2">
						<div class="progress ng-cloak" ng-show="progress">
						  <div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="[[progress]]" aria-valuemin="0" aria-valuemax="100" style="width: [[progress]]%;">
						    [[progress]]%
						  </div>
						</div>
						<div class="thumbnail" ng-file-select ng-model="image_upload" accept=".jpg,.png" style="height:120px; background-image:url('[[image || '/img/no-image.jpg']]'); background-size: 100%;"></div>
						<input type="hidden" value="[[image]]" name="image" />
					</div>
				</div>--}}

				<div class="row form-group">
					<label class="col-md-4 control-label">分类图标(前端):</label>
					<div class="col-md-2">
			      		<input class='upload-pic' type="file" id="pic_logo" name="image" style="display:none">
						@if(!empty($category->image))
						<img src="{{$category->image}}" alt="点击" class="thumbnail" onclick="$('input[id=pic_logo]').click();" width="40px" height="40px" style="cursor:pointer">
						@else
						<img src="[['/img/no-image.jpg']]" alt="点击" class="thumbnail" onclick="$('input[id=pic_logo]').click();" width="120px" height="120px" style="cursor:pointer">
						@endif
					</div>
				</div>

				<div class="row form-group">
					<label class="col-md-4 control-label">广告图(纵向):</label>
					<div class="col-md-2">
			      		<input class='upload-pic' type="file" id="pic_h" name="image-h" style="display:none">
			      		@if(!empty($category->image_h))
						<img src="{{$category->image_h}}" alt="点击" class="thumbnail" onclick="$('input[id=pic_h]').click();" width="80px" height="140px" style="cursor:pointer">
						@else
						<img src="[['/img/no-image.jpg']]" alt="点击" class="thumbnail" onclick="$('input[id=pic_h]').click();" width="80px" height="140px" style="cursor:pointer">
						@endif
					</div>
				</div>

				<div class="row form-group">
					<label class="col-md-4 control-label">广告图(横向):</label>
					<div class="col-md-2">
			      		<input class='upload-pic' type="file" id="pic_w" name="image-w" style="display:none">
			      			@if(!empty($category->image_w))
								<img src="{{$category->image_w}}" alt="点击" class="thumbnail" onclick="$('input[id=pic_w]').click();" width="440px" height="100px" style="cursor:pointer">
							@else
								<img src="[['/img/no-image.jpg']]" alt="点击" class="thumbnail" onclick="$('input[id=pic_w]').click();" width="440px" height="100px" style="cursor:pointer">
							@endif
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">{{ trans('categories.select_icon') }}</label>
					<div class="col-md-6 demo-icons">
						<div class="demo-content">
							@foreach(trans('categories.class_icons') as $row)
								<span class="{{ $row }}" ng-click="icon='{{ $row }}'"></span>
							@endforeach
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label"></label>
					<div class="col-md-6 demo-icons">
						<div class="demo-content">
							<span class="[[icon]]">[[icon]]</span>
							<input type="hidden" name="icon" ng-model="icon" value="[[icon]]" />
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">主题颜色</label>
					<div class="col-md-6">
						{!! Form::select('color',["green"=>'绿色',"red"=>'红色',"orange"=>'橙色',"blue"=>'蓝色',"purple"=>'紫色',],null,['class'=>'form-control']) !!}
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">{{ trans('globals.status') }}</label>
					<div class="col-md-6">
						{!! Form::select('status',[1=>trans('globals.active'),0=>trans('globals.inactive')],null,['class'=>'form-control']) !!}
					</div>
				</div>
				<div class="form-group" ng-init="type=1">
					<label class="col-md-4 control-label">{{ trans('globals.type') }}</label>
					<div class="col-md-6">
						{!! Form::select('type',[1=>trans('globals.type_categories.group'),2=>trans('globals.type_categories.store')],null,['class'=>'form-control','ng-model'=>'type']) !!}
					</div>
				</div>
				@if(count($categories['group'])>0)
					<div class="form-group" ng-show="type==1">
						<label class="col-md-4 control-label">{{ trans('categories.parent_category').' ('.trans('globals.type_categories.group').')' }}</label>
						<div class="col-md-6">
							{!! Form::select('parentg',$groupCategories,null,['class'=>'form-control']) !!}
						</div>
					</div>
				@endif
				@if(count($categories['store'])>0)
					<div class="form-group" id="parents" ng-show="type==2">
						<label class="col-md-4 control-label">{{ trans('categories.parent_category').' ('.trans('globals.type_categories.store').')' }}</label>
						<div class="col-md-6">
							{!! Form::select('parents',$storeCategories,null,['class'=>'form-control']) !!}
						</div>
					</div>
				@endif
				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<button type="submit" class="btn btn-primary">
							{{ trans('globals.save') }}
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@stop
@section('scripts')
    @parent
    {!! Html::script('/js/vendor/file-upload/angular-file-upload-shim.min.js') !!}
    {!! Html::script('/js/vendor/file-upload/angular-file-upload.min.js') !!}
	{!! Html::script('/js/vendor/deleted/jquery.min.js') !!}

	<script>
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
            app.controller('CategoryController', ['$scope', '$upload','$timeout','notify',
            		function ($scope, $upload, $timeout, notify) {
            	//content
                $scope.category=({!! $category->toJson() !!});
                var status_list={
                        0:'{{ trans('globals.inactive') }}',
                        1:'{{ trans('globals.active') }}'
                    },
                    type_list=({!! json_encode(trans('globals.type_categories')) !!});
                $scope.status=function(){
                    return status_list[($scope.category.status!==undefined&&$scope.category.status)||1];
                };
                $scope.link=function(){
                    return '{{ route('wpanel.category.edit','ID') }}'.replace('ID',$scope.category.id);
                };
                $scope.type=function(){
                    return type_list[$scope.category.type];
                };
                //upload
				$scope.image=$scope.category.image;
				$scope.image_upload='';
				$scope.progress= '';
				$scope.$watch('category.image', function () {
					$scope.image=$scope.category.image;
				});
				$scope.$watch('image_upload', function () {
					$scope.upload($scope.image_upload);
				});
				$scope.upload = function (files) {
					if (files && files.length) {
						for (var i = 0; i < files.length; i++) {
							var file = files[i];
							var url='/wpanel/category/upload';
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
                                    notify({duration:4000,message:data,classes:'alert alert-danger'});

                                }else{
									$scope.category.image=data;
                                    $timeout(function(){
                                        $scope.progress= '';
                                    }, 1000);
                                }
							});
						}
					}
				};
			}]);
		})(angular.module("AntVel"))
	</script>
@stop
@section('before.angular') ngModules.push('angularFileUpload'); @stop
