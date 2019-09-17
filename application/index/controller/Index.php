<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;

class Index extends Controller
{
    //前台微信登录
    public function wxLogin()
    {

    }
    
    //前台展示首页
    public function index()
    {
        $data = goods::all();
        return $this->fetch('',['data' => $data]);
    }

    //商品详情
    public function goodInfo()
    {
        $data = goods::all();
        return $this->fetch('',['data' => $data]);
    }

    //商品微信支付页
    //判断是否登录  否 跳转到登录页   是  查询订单表 关联 个人中心表
    //判断是为朋友支付还是为自己支付（前端传来一个识别标识）
    //为自己购买支付成功-->更改order(订单表)状态(添加到我的权益)
    //为他人购买支付成功后 获取提货码->验证提货码   更改order(订单表)状态(添加到我的权益)
    public function wxPay()
    {

    }

    //个人权益中心
    public function center(Request $request)
    {
        //两种情况，1.自己的VIP服务， 2.他人的VIP服务 返回的数据区分开
        $goods = Db::table('goods')->get();
        $res = Db::table('center')->get();
    }

    //权益使用接口
    public function apply()
    {

    }

    //提货码
    public function code(Request $request)
    {
        function createRandomStr1($length){
            $str = array_merge(range('a','z'),range('A','Z'));
            shuffle($str);
            $str = implode('',array_slice($str,0,$length));
            return $str;
        }
        $first = createRandomStr1(2);
        function createRandomStr2($length){
            $str = array_merge(range('0','9'));
            shuffle($str);
            $str = implode('',array_slice($str,0,$length));
            return $str;
        }
        $two = createRandomStr2(6);
        //字符串之间的拼接
        $data = $first.$two;
        //todo 存入数据库
//        $userId= $request->param();
//        $res = Db::table('order')->insert(['user_id'=>$userId,'code'=>$data]);
        return json([
            'url'=>'yiliao.com/index',
            'code'=>0,
            'msg'=>'返回成功',
            'data'=>$data
        ]);
    }

    //验证前端发来的提货码
    public function check(Request $request)
    {
        $code = $request->param();
        $Code = Db::table('order')->field('code')->find();
        if($code === $Code){
            //提货码验证成功

        }else{
            //提货码验证失败

        }

    }

}
