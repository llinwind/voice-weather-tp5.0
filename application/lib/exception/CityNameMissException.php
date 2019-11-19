<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/31 0031
 * Time: 下午 3:53
 */

namespace app\lib\exception;


class CityNameMissException extends BaseException
{
    public $code = 404;
    public $msg = '未找到该城市信息';
    public $errCode = 2001;
}