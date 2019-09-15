<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;

class Index extends Controller
{
    public function index(Request $request)
    {
        function createRandomStr1($length){
            //生成包含a-z,A-Z的数组
            $str = array_merge(range('a','z'),range('A','Z'));
            //打乱数组
            shuffle($str);
            //array_slice从数组中截取长度为$length的字符串
            //implode(separator,array)
            //separactor可选。规定数组元素之间放置的内容。默认是 ""（空字符串）。
            //array必需。要组合为字符串的数组。
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
        return json([
            'url'=>'mask.com/index',
            'code'=>0,
            'msg'=>'返回成功',
            'data'=>$data
        ]);
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
