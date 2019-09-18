<?php

namespace app\admin\controller;

use app\admin\model\goods;
use app\admin\model\user;
use think\Controller;
use think\Db;
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

    public function userlist(Request $request)
    {
        $data = user::all();
//        return json($this->assign('member-list1',['data'=>$data]));
        return $this->fetch('user-list',['data' => $data]);
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

    /**
     * 保存新建的资源     商品添加
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
        if($request->isPost()){
            $data = $request->only(['name','price']);
//            return $data['name'];
            $res = Db::table('goods')->insert(['name'=>$data['name'],'price'=>$data['price']]);
//            $res = goods::($data);
            if($res){
                return json([
                    'code'=>0,
                    'msg' =>'添加成功',
                ]);
            }else{
                return json([
                    'code'=>1,
                    'msg' =>'添加失败'
                ]);
            }
        }
    }


    //返回要修改服务的信息
    public function update(Request $request,$id)
    {
        $goods = Goods::get($id);
        if(empty($goods)){
            return json([
                'code'=>1,
                'msg'=>'没有您要修改的商品'
            ]);
        }else{
            return json([
                'code'=>0,
                'msg'=>'商品信息',
                'data'=>$goods
            ]);
        }
    }
    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function edit(Request $request,$id)
    {
        if($request->isPost()){
            $data = $request->only(['name','price']);
            $res = Db::table('goods')->where('id',$id)->update(['name'=>$data['name'],'price'=>$data['price']]);
            if($res){
                return json([
                   'code'=>0,
                   'msg' =>'修改成功',
                ]);
            }else{
                return json([
                    'code'=>1,
                    'msg' =>'修改失败',
                ]);
            }
        }
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
