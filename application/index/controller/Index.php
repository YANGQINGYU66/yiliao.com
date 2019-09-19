<?php
namespace app\index\controller;
use app\admin\model\goods;
use think\Controller;
use think\Db;
use think\facade\Validate;
use think\Request;
use think\response\Json;

class Index extends Controller
{
    // 前台首页  获取服务信息   todo  ok
    public function index(Request $request)
    {
    //  商品名称，价格，已售出数量
        if($request->isGet()){
            $goods = Db::table('goods')->all();
            $num = Db::table('order')->count();
            $res = json([
                "error_code"=>0,
                "message" =>"获取数据成功",
                "data"=>[
                    "serviceName"=> $goods[0]['name'],
                    "servicePrice"=> $goods[0]['price'],
                    "num"       =>$num,
                    "favourablePrice"=>"优惠价格",
                    "serviceImg"=> "服务图片",
                    "serviceParticularsImg"=> "服务详情图片",
                    "serviceId"=> "服务ID",
                    "serviceParticulars"=>"服务详情介绍"
                ]
            ]);
            return $res;
        }

    }


    //前台微信登录
    public function wxLogin()
    {
        //开发者使用登陆凭证 code 获取 session_key 和 openid
        $APPID = '';//自己配置
        $AppSecret = '';//自己配置
        $code = input('code');
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $APPID . "&secret=" . $AppSecret . "&js_code=" . $code . "&grant_type=authorization_code";
        $arr = $this->vget($url); // 一个使用curl实现的get方法请求
        $arr = json_decode($arr, true);
        $openid = $arr['openid'];
        $session_key = $arr['session_key'];
        // 数据签名校验
        $signature = input('signature');
        $rawData = Request::instance()->post('rawData');
        $signature2 = sha1($rawData . $session_key);
        if ($signature != $signature2) {
            return json(['code' => 500, 'msg' => '数据签名验证失败！']);
        }
        Vendor("PHP.wxBizDataCrypt"); //加载解密文件，在官方有下载
        $encryptedData = input('encryptedData');
        $iv = input('iv');
        $pc = new \WXBizDataCrypt($APPID, $session_key);
        $errCode = $pc->decryptData($encryptedData, $iv, $data); //其中$data包含用户的所有数据
        $data = json_decode($data);
        if ($errCode == 0) {
            dump($data);
            die;//打印解密所得的用户信息
        } else {
            echo $errCode;//打印失败信息
        }
    }

        public function vget($url){
        $info=curl_init();
        curl_setopt($info,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($info,CURLOPT_HEADER,0);
        curl_setopt($info,CURLOPT_NOBODY,0);
        curl_setopt($info,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($info,CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($info,CURLOPT_URL,$url);
        $output= curl_exec($info);
        curl_close($info);
        return $output;
    }

    //商品微信支付页
    //判断是否登录  否 跳转到登录页   是  查询订单表 关联 个人中心表
    //判断是为朋友支付还是为自己支付（前端传来一个识别标识）
    //为自己购买支付成功-->更改order(订单表)状态(添加到我的权益)
    //为他人购买支付成功后 获取提货码->验证提货码   更改order(订单表)状态(添加到我的权益)
    public function wxPay()
    {

    }

    // 获取我的权益表     todo
    public function center(Request $request)
    {
        if($request->isPost()){
            $openid = $request->param();
            $goods = Db::table('goods')->all();
            //dump($goods[0]);echo '<hr/>';
            if(!empty($goods)){
                $res_arr = array();
                foreach ($goods[0] as $key =>$val) {
                    $res_arr[$key] = $val;
                }
            }else{
                $res = '没有对应的商品数据';
            }
            $openid = $openid?$openid:'1';
            $order = Db::table('order')->where('openid',$openid)->selectOrFail();
            if($order>0){
                $res_order = array();
                foreach ($order[0] as $key =>$val) {
                    $res_order[$key]= $val;
                }
            }else{
                $res = '订单信息为空';
            }

            $type = $request->param();
//            我的服务
            if(type == 0){

            }else{                              //为他人购买

            }
            if(isset($res)){
                return $res;
            }else {
                $return_res = [
                    "error_code" => 0,
                    "message" => "获取数据成功",
                    "data" => [
                        "isHaveNextPage" => '',
                        "count"=>'',
                        "serviceList" => json([
                            "serviceName" => $res_arr['name'],
                            "orderId" => $res_order['orderCode'],
                            "serviceNum" => $res_order['total'],
                            "usedableNum" => $res_order['total']-$res_order['num'],
                            "serviceParticulars" => $res_arr['introduce'],
                            "servicePrice" => $res_arr['price'],
                            "serviceState" => '',
                            "serviceParticularsImg" => "",
                            "serviceImg" => "",
                            "favourablePrice" => ""
                        ])
                    ]
                ];
            }
           return json($return_res['data']);
        }
    }

    // 权益使用接口  todo  ok
    public function apply(Request $request)
    {
        if ($request->isGet()) {
            $userId = $request->param();
            $order_id = 1;
            $data = Db::table('center')->where('orderCode', $order_id)->field('type')->select();
            $type =  json($data[0]['type']);
//            return $ismy;
            //如果个人中心是自己的
            if ($type == 0) {
                $num = Db::table('order')->field(['num','total'])->select();
                $use_num =  json($num[0]['num']);
                $total = json($num[0]['total']);
                if($use_num >= $total){
                    return json([
                        'code'=>1,
                        'msg'=>'使用次数已用完'
                    ]);
                }else{
                    $res = Db::table('order')->where('userId',$userId)->update('num',$use_num+1);
                    return json([
                        'code'=>0,
                        'msg'=>'成功'
                    ]);
                }
            } else {
                //不是自己的
                //跳转到获取提货码页
                return json([
                    //提货码路径
                    'msg' =>'请先获取提货码',
                    'url' => 'yiliao.com/tihuoma'
                ]);
            }
        }
    }

    // 获取提货码  todo ok
    public function code(Request $request)
    {
        if($request->isPost()){
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
            $code = $first.$two;
            //todo 存入数据库
        $data= $request->only(['userId','orderId']);
        Db::table('order')->insert(['user_id'=>$data['userId'],'orderId'=>$data['orderId'],'code'=>$code]);
            $return_res = [
                'error_code'=>0,
                'msg'=>'获取兑换码成功',
                'data'=>$data
            ];
            return json($return_res);
        }
    }

    // todo 兑换服务  todo ok
    public function check(Request $request)
    {
        if($request->isPost()){
            $code = $request->param('code');
            $userId = $request->param('userId');
            $num = Db::table('order')->field(['num','total'])->select();
            $use_num =  json($num[0]['num']);
            $total = json($num[0]['total']);
            if($use_num >= $total){
                return json([
                    'code'=>1,
                    'msg'=>'使用次数已用完'
                ]);
            }else{
                $Code = Db::table('code')->where('userId',$userId)->field('code')->select();
                if($code === $Code){
                    //提货码验证成功
                    $res = Db::table('order')->where('userId',$userId)->update('status',1);
                    return json([
                        'code'=>0,
                        'msg'=>'兑换成功'
                    ]);
                }else{
                    //提货码验证失败
                    return json([
                        'code'=>1,
                        'msg' =>'兑换失败',
                    ]);
                }
            }
        }
    }

    //接收前端发的用户信息   todo ok
    public function userInfo(Request $request)
    {
        if($request->isPost()){
            $data = $request->only(['name','mobile','cardId']);
            //验证数据
            $rule = [
                'name' => 'require|length:2,20',
                'mobile' => 'require|length:11,13',
                'cardId' => 'required|regex:/^[1-6,8][0-9]{5}[1,2,3][0-9]{3}[0,1][0-9][0-3][0-9][0-9]{3}[0-9,X]$/|unique:address'
            ];
            $msg = [
                'name.require' => '用户名为必填项',
                'name.length' => '用户名的长度应该在2-20之间',
                'mobile.length' => '联系电话长度有误',
                'cardId' =>'身份证号码填写有误'
            ];
            $check = $this->validate($data, $rule, $msg);
            if ($check === true) {
                //验证通过数据入库
                $res =  Db::table('user')->insert($data);
                if($res == true){
                    return json([
                        'code'=>0,
                        'msg'=>'成功'
                    ]);
                }else{
                    return json([
                        'code'=>1,
                        'msg'=>'失败'
                    ]);
                }
            }else {
                //前端输入的数据有误
                return json([
                    'code'=>1,
                    'msg'=>$check
                ]);
            }
        }
    }
}
