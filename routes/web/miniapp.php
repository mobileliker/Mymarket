<?php 

//微信 小程序接口
Route::group(['prefix' => 'miniapp','namespace' => 'miniapp'], function () {
	// 首页
	Route::get('/home', 'HomeController@index');
	Route::get('/', 'HomeController@index');

	Route::get('/getopenid', 'LoginController@getOpenid');//获取openid
	Route::get('/gettoken', 'LoginController@gettoken');//获取token
	Route::get('/loginauthuser', 'LoginController@loginAutoUser');//判断是否登录
	Route::post('/login', 'LoginController@login');//登录
	Route::get('/layout', 'LoginController@layout');//退出登录

	Route::get('/list', 'ProductController@index');//列表页
	Route::get('/product/{id}', 'ProductController@product');//商品详情页
	Route::get('/product/screen/category', 'ProductController@screen_category');//商品分类查询
	Route::get('/product/screen/brand', 'ProductController@screen_brand');//商品品牌查询
	Route::get('/product/comment/{id}', 'ProductController@comment');//商品评论详情页

	Route::get('/help', 'ArticleController@index');//帮助中心首页
	Route::get('/help/content/{id}', 'ArticleController@articleContent');//帮助中心内容

	//解密openid
	Route::get('/decode', 'DecodeController@index');

	//登录后可访问的接口

	Route::post('/order/pay', 'OrderController@pay');//商品支付接口
	Route::get('/order/getpayinfo', 'OrderController@payInfo');//获取预支付信息

	Route::post('/order/create', 'OrderController@create');//create商品生成订单
	Route::post('/order/store', 'OrderController@store');//store保存订单
	Route::post('/order/update', 'OrderController@update');//update更改订单状态
	Route::get('/order/delete/{id}', 'OrderController@destory');//delete删除订单
	Route::get('/order', 'OrderController@index');//订单查询
	Route::get('/order/details/{id}', 'OrderController@order_details');//订单详情

	Route::get('/address/default/{id}', 'AddressController@default');//用户默认地址修改
	Route::post('/address/store', 'AddressController@store');//store保存地址
	Route::post('/address/update', 'AddressController@update');//update编辑地址
	Route::get('/address/delete/{id}', 'AddressController@destory');//delete删除地址
	Route::get('/address/edit/{id}', 'AddressController@edit');//delete删除地址
	Route::get('/address', 'AddressController@index');//地址查询

});


?>