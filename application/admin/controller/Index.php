<?php

namespace app\admin\controller;

use app\admin\model\goods;
use app\admin\model\user;
use think\Controller;
use think\Request;

class Index extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //后台首页
        //view()表示访问当前模块下的view目录
        //返回view层中选中的页面，不写.html后缀
        return view("../view/index.html");

    }

    public function memberlist(Request $request)
    {
        $data = user::all();
//        return json($this->assign('member-list1',['data'=>$data]));
        return $this->fetch('member-list',['data' => $data]);
    }

    public function goodlist(Request $request)
    {
        $data = goods::all();
//        return json($this->assign('member-list1',['data'=>$data]));
        return $this->fetch('good-list',['data' => $data]);
    }

    public function test(Request $request)
    {
        $data = goods::all();
//        $data = '1111';
        return json([
            'url'=>'yiliao.com/test',
            'code'=>0,
            'msg'=>'返回成功',
            'data'=>$data
        ]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
