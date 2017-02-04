<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" ng-app="AntVel">
<head>
	@section('metaLabels')
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="/">
		<meta name="description" content="">
		<meta name="author" content="">
	@show

	<link rel="icon" href="favicon.ico">
	<title>@section('title'){{ $main_company['website_name']}} @show</title>



	{{-- Antvel CSS files --}}
	{!! Html::style('/antvel-bower/bootstrap/dist/css/bootstrap.css') !!}
	{!! Html::style('/css/app.css') !!}

	@section('css')

	@show

</head>
<body>


@section('celerity')
	@include('szy.layouts.celerity')
@show

@section('header')
	@include('szy.layouts.list-header')
@show

@section('content')

@show


@section('footer')
	@include('szy.layouts.footer')
@show

</body>


{{-- Antvel - Bower Components --}}

{!! Html::script('/antvel-bower/angular/angular.min.js') !!}
{!! Html::script('/antvel-bower/angular-route/angular-route.min.js') !!}
{!! Html::script('/antvel-bower/angular-sanitize/angular-sanitize.min.js') !!}
{!! Html::script('/antvel-bower/angular-bootstrap/ui-bootstrap-tpls.min.js') !!}
{!! Html::script('/antvel-bower/angular-animate/angular-animate.min.js') !!}
{!! Html::script('/antvel-bower/angular-loading-bar/build/loading-bar.min.js') !!}
{!! Html::script('/antvel-bower/angular-mocks/angular-mocks.js') !!}
{!! Html::script('/antvel-bower/angular-touch/angular-touch.min.js') !!}
{!! Html::script('/antvel-bower/bootstrap/dist/js/bootstrap.min.js') !!}

{!! Html::script('/js/vendor/xtForms/xtForm.js') !!}
{!! Html::script('/js/vendor/xtForms/xtForm.tpl.min.js') !!}

<script>

	/**
	 * ngModules
	 * Angularjs modules requires by antvel
	 * @type {Array}
	 */
	var ngModules = [
		'ngRoute', 'ngSanitize', 'LocalStorageModule',
		'ui.bootstrap', 'chieffancypants.loadingBar', 'xtForm',
		'cgNotify', 'ngTouch', 'angucomplete-alt'
	];

	@section('before.angular') @show

	(function(){
		angular.module('AntVel',ngModules,
		function($interpolateProvider){
			$interpolateProvider.startSymbol('[[');
			$interpolateProvider.endSymbol(']]');
		}).config(function(localStorageServiceProvider, cfpLoadingBarProvider,$locationProvider){
			cfpLoadingBarProvider.includeSpinner = false;
			localStorageServiceProvider.setPrefix('tb');
			$locationProvider.html5Mode({enabled:true,rewriteLinks:false});
		});
	})();

</script>

{{-- Antvel functions --}}
{!! Html::script('/js/app.js') !!}

@section('scripts')
	{!! Html::script('/js/szy/jquery-1.8.3.min.js') !!}

	{{-- Antvel angucomplete-alt.js version --}}
	{!! Html::script('/js/vendor/angucomplete-alt.js') !!}

	{{-- Antvel-bower components --}}
	{!! Html::script('/antvel-bower/angular-notify/dist/angular-notify.min.js') !!}
	{!! Html::script('/antvel-bower/angular-local-storage/dist/angular-local-storage.min.js') !!}
@show

</html>
