<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
//        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V5.1<br/><span style="font-size:30px">12载初心不改（2006-2018） - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
//        return $this->fetch("index/index");
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
        $str = $first.$two;
        echo $str;
    }

    public function test()
    {
        return 111;
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
