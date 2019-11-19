<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/31 0031
 * Time: 下午 3:02
 */

namespace app\api\controller;


use app\lib\exception\ParameterException;
use think\Controller;

class Miss extends Controller
{
    public function miss(){
        throw new ParameterException([
            'code' => 404,
            'msg' => '此路由不存在',
            'errCode' => 4000
        ]);
    }
}