<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/3 0003
 * Time: 上午 11:27
 */

namespace app\lib\exception;


class WeatherMissException extends BaseException
{
    public $code = 404;
    public $msg = '未找到该城市天气信息';
    public $errCode = 2002;
}