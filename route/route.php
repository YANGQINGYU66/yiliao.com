<?php

//todo 后台路由 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//后台登录页面
//use think\Route;

Route::get('login', function () {
    return view('../application/admin/view/login.html');
});
//后台首页
Route::get('admin', function () {
    return view('../application/admin/view/index.html');
});

Route::get('log', function () {
    return view('../application/admin/view/unicode.html');
});
Route::get('member-list', 'admin/index/memberlist');
Route::get('member-list1', function () {
    return view('../application/admin/view/member-list.html');
});
Route::get('member-add', function () {
    return view('../application/admin/view/member-add.html');
});
Route::get('member-del', function () {
    return view('../application/admin/view/member-del.html');
});
Route::get('good-list', 'admin/index/goodlist');
Route::get('good-list1', function () {
    return view('../application/admin/view/good-list.html');
});
Route::get('good-del', function () {
    return view('../application/admin/view/good-del.html');
});
Route::get('admin-list', function () {
    return view('../application/admin/view/admin-list.html');
});
Route::get('order-list', function () {
    return view('../application/admin/view/order-list.html');
});
Route::get('order-list1', function () {
    return view('../application/admin/view/order-list1.html');
});
Route::get('cate', function () {
    return view('../application/admin/view/cate.html');
});

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

//todo 前台路由

//前台微信登录页面
Route::get('in', function () {
    return view('../application/index/view/index/login.html');
});
//前台首页
Route::get('index','index/Index/index');
//商品详情
Route::get('goodInfo','index/Index/goodInfo');
//微信支付
Route::post('wxpay','index/Index/wxPay');
//个人权益中心
Route::get('center','index/Index/center');
//权益使用
Route::get('apply','index/Index/apply');
//提货码
Route::get('tihuoma', function () {
    return view('../application/index/view/index/tihuoma.html');
});
Route::get('code','index/Index/code');