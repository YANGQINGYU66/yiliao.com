<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//后台路由
Route::get('admin', function () {
    return view('../application/admin/view/index.html');
});
Route::get('log', function () {
    return view('../application/admin/view/unicode.html');
});
Route::get('member-list', function () {
    return view('../application/admin/view/member-list.html');
});
Route::get('member-del', function () {
    return view('../application/admin/view/member-del.html');
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
Route::get('tihuoma', function () {
    return view('../application/index/view/index/tihuoma.html');
});

Route::get('index', function () {
    return view('../application/index/view/index/index.html');
});

Route::get('login', function () {
    return view('../application/admin/view/login.html');
});

Route::get('test', function () {
    return view('../application/admin/view/test.html');
});

Route::get('in','index/Index/index');
Route::get('test1','admin/Index/test');
Route::get('hello/:name', 'index/hello');

//Route::get("admin","admin/Index/index");
return [

];
