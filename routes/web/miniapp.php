<?php 

//微信 小程序接口
Route::group(['prefix' => 'miniapp','namespace' => 'miniapp'], function () {
	// 首页
	Route::get('/home', 'HomeController@index');
	Route::get('/', 'HomeController@index');

	Route::get('/list', 'ProductController@index');//列表页
	Route::get('/product/{id}', 'ProductController@product');//商品详情页
	Route::get('/product/comment/{id}', 'ProductController@comment');//商品评论详情页

	Route::get('/help', 'ArticleController@index');//帮助中心首页
	Route::get('/help/content/{id}', 'ArticleController@articleContent');//帮助中心内容

	//登录后可访问的接口
	Route::group(['middleware' => 'auth'], function () {

		Route::post('/order/pay', 'OrderController@pay');//商品支付接口
		Route::resource('/order', 'OrderController');//订单增删改查（create商品生成订单、store保存订单、update更改订单状态、delete删除订单）
		Route::get('/order/details/{id}', 'OrderController@order_details');//订单详情

		Route::get('/address/default/{id}', 'AddressController@default');//用户默认地址修改
		Route::resource('/address', 'AddressController');//地址增删改查
	});
});


?>