<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TestController extends Controller
{
    //curl测试 form-data
    public function curlpost(){
        $userinfo=[
            'name'=>'lisi',
            'pass'=>'1234'
        ];

        $url="http://api.1906.com/test/post1";

        //初始化
        $ch=curl_init($url);

        //设置参数
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER ,1);
        //post请求
        curl_setopt($ch,CURLOPT_POST,1);
        //发送数据 form-data形式
        curl_setopt($ch,CURLOPT_POSTFIELDS,$userinfo);

        //开启会话
        $data=curl_exec($ch);
        var_dump($data);

        //捕获并处理错误
        $errno=curl_errno($ch);
        $error=curl_error($ch);
        if($errno>0){   //错误码为0则是不报错
            echo "错误码：".$errno;echo "<br>";
            echo "错误信息:".$error;die;
            die;
        }

        //关闭会话
        curl_close($ch);
    }


     //curl测试 form-urlencoded
    public function curlpost1(){
        //urlencoded格式
        $str = "name=张三&sex=男&age=20";

        $url = "http://api.1906.com/test/post2";

        //初始化
        $ch = curl_init($url);

        //设置参数选项
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        //POST请求
        curl_setopt($ch,CURLOPT_POST,1);

        //发送数据  form-urlencoded形式
        curl_setopt($ch,CURLOPT_POSTFIELDS,$str);

        //执行会话
        $data = curl_exec($ch);
        var_dump($data);

        //捕获错误
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        if($errno > 0){
            echo "错误码：".$errno;echo "<br>";
            echo "错误信息：".$error;die;
        }

        //关闭会话
        curl_close($ch);
    }

    //curl测试 raw(json字符串)
    public function curlpost2(){
        $user_info = [
            'user_name' => 'hello',
            'sex'       => '男',
            'age'       =>  '20',
        ];

        $json = json_encode($user_info);

        $url = "http://api.1906.com/test/post3";

        //初始化
        $ch = curl_init($url);

        //设置参数选项
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        //POST请求
        curl_setopt($ch,CURLOPT_POST,1);

        //发送数据  raw(json)形式
        curl_setopt($ch,CURLOPT_POSTFIELDS,$json);

        //执行会话
        $response = curl_exec($ch);
        var_dump($response);

        //捕获错误
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        if($errno > 0){
            echo "错误码：".$errno;echo "<br>";
            echo "错误信息：".$error;die;
        }

        //关闭会话
        curl_close($ch);
    }

    //访问接口上传文件
    public function upload(){
        //文件与数据
        $fiel_info = [
            'user_name' => '派大星',
            'age' => '19',
            'img' => new \CURLFile('aaaa.jpg') //或者storage_path(imgs/bbbb.jpg);
        ];

        $url = "http://api.1906.com/test/upload";
        //echo $url;

        //初始化
        $ch = curl_init($url);

        //设置参数选项
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        //POST请求
        curl_setopt($ch,CURLOPT_POST,1);

        //发送数据  raw(json)形式
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fiel_info);

        //执行会话
        $response = curl_exec($ch);

        //数据处理
        var_dump($response);

        //捕获错误
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        if($errno > 0){
            echo "错误码：".$errno;echo "<br>";
            echo "错误信息：".$error;die;
        }

        //关闭会话
        curl_close($ch);
    }

    //guzzle get请求
    public function guzzle(){
        $url = "http://api.1906.com/guzzle/guzzle";
        $client = new Client();
        $response = $client->request('GET',$url,[
            'query' => [
                'name' => '张三',
                'sex'  => '男',
                'age'  => '20'
            ]
        ]);

        //获取服务端响应的数据
        $data = $response->getBody();

        echo $data;
    }

    //guzzle post请求
    public function guzzle1(){
        $url = "http://api.1906.com/guzzle/guzzle1";
        $client = new Client();
        $response = $client->request('POST',$url,[
            'form_params' => [
                'name' => '李四',
                'sex'  => '男',
                'age'  => '19'
            ]
        ]);

        //获取服务端响应的数据
        $data = $response->getBody();

        echo $data;
    }

    //Guzzle上传文件(POST请求  必须使用form-data)
    public function guzzleUpload(){
        $url = "http://api.1906.com/guzzle/guzzleUpload";
        $client = new Client();
        $response = $client->request('POST',$url,[
            'multipart' => [
                [
                    'name' => 'user_name',
                    'contents'  => '海绵宝宝'
                ],
                [
                    'name'          => 'LOGO',
                    'contents'      => fopen('aaaa.jpg','r')
                ]
            ]
        ]);

        //获取服务端响应的数据
        $data = $response->getBody();

        echo $data;
    }
}
