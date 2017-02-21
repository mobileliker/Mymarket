<?php 

//微信 小程序接口
Route::group(['prefix' => 'miniapp','namespace' => 'miniapp'], function () {
	// 首页
	Route::get('/home', 'HomeController@index');
	Route::get('/', 'HomeController@index');

	//列表页
	Route::get('/list', 'ProductController@index');

	//商品详情页
	Route::get('/product/{id}', 'ProductController@product');

	//商品评论详情页
	Route::get('/product/comment/{id}', 'ProductController@comment');

	//商品确认订单
	Route::get('/product/order/aff', 'ProductController@orderAff');

	//商品生成订单
	Route::post('/order/add', 'OrderController@order');

	//商品支付接口
	Route::post('/order/pay', 'OrderController@pay');

	//用户默认地址修改
	Route::get('/address/default/{id}', 'AddressController@default');

	//地址增删改查
	Route::resource('/address', 'AddressController');
});


?>