<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/31 0031
 * Time: 上午 10:51
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    public $code = 400;
    public $msg = '参数错误';
    public $errCode = 1000;

    public function __construct($params)
    {
        if(!is_array($params)){
            return;
        }

        if(array_key_exists('code', $params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('msg', $params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('errCode', $params)){
            $this->errCode = $params['errCode'];
        }
    }
}