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
    //前台展示首页
    public function index()
    {
        $data = goods::all();
        return $this->fetch('index',['data' => $data]);
    }

    //商品详情
    public function goodInfo()
    {
        $data = goods::all();
        return $this->fetch('',['data' => $data]);
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

    //个人权益中心
    public function center(Request $request)
    {
        //两种情况，1.自己的VIP服务， 2.他人的VIP服务 返回的数据区分开
        $goods = Db::table('goods')->get();
        $myres = Db::table('center')->wehere('ismy',1)->get();
        $notmyres = Db::table('cnter')->where('ismy',0)->get();
        return $this->fetch('center',['myres'=>$myres,'notmyres'=>$notmyres]);
    }

    //权益使用接口
    public function apply(Request $request)
    {
        if ($request->isPost()) {
            $order_id = $request->param('');
            $ismy = Db::table('center')->where('oeder_id', $order_id)->get('ismy');
            //如果个人中心是自己的
            if ($ismy == 1) {
                $res = Db::table('center')->where('order_id', $order_id)->update('isuse', 1);
                if ($res) {
                    return json([
                        'code' => 0,
                        'msg' => '成功',
                        //跳转到填写身份信息路径
                        'url' => ''
                    ]);
                } else {
                    return json([
                        'code' => 1,
                        'msg' => '失败'
                    ]);
                }
            } else {
                //不是自己的
                //跳转到获取提货码页
                return json([
                    //提货码路径
                    'url' => 'yiliao.com/tihuoma'
                ]);
            }
        }
    }

    //获取提货码
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
        //$userId= $request->param();
        //$res = Db::table('order')->insert(['user_id'=>$userId,'code'=>$data]);
        return json([
            //返回获取提货码当前页
            'url'=>'yiliao.com/tihuoma',
            'code'=>0,
            'msg'=>'获取兑换码成功',
            'data'=>$data
        ]);
    }

    //验证前端发来的提货码
    public function check(Request $request)
    {

        $code = $request->param();
        $Code = Db::table('order')->field('code')->find();
        if($code === $Code){
            //提货码验证成功   跳转到填写身份信息
            return redirect('');
        }else{
            //提货码验证失败
            return json([
                'code'=>1,
                'msg' =>'您输入的提货码有误',
                //刷新一下当前页面
                'url' =>''
            ]);
        }
    }

    //接收前端发的用户信息
    public function userInfo(Request $request)
    {
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
            if($res){
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
                'msg'=>''
            ]);
        }
    }
}
