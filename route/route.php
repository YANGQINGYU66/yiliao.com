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
Route::get('user-list', 'admin/index/userlist');
Route::get('user-list1', function () {
    return view('../application/admin/view/user-list.html');
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
Route::post('good-add', 'admin/index/create');
Route::get('good-add1', function () {
    return view('../application/admin/view/index/good-add.html');
});
Route::get('good-edit', 'admin/index/edit');
Route::get('good-edit1', function () {
    return view('../application/admin/view/index/good-edit.html');
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
    return '1211';
});

//前台首页  获取服务信息
Route::get('index','index/Index/index');
//去购买页
Route::get('goodInfo','index/Index/goodInfo');
//微信支付
Route::get('wxpay','index/Index/wxPay');
//生成订单
Route::get('order','index/Index/order');

//个人权益中心
Route::get('center','index/Index/center');

//兑换服务
Route::get('apply','index/Index/apply');

//提货码
Route::get('code','index/Index/code');

//验证提货码
Route::get('check','index/Index/check');

//提交个人信息
Route::get('userInfo','index/Index/userInfo');