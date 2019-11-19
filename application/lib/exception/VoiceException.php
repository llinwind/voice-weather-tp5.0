<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/4 0004
 * Time: 下午 1:40
 */

namespace app\lib\exception;


class VoiceException extends BaseException
{
    public $code = 400;
    public $msg = '语音转换错误，请重说';
    public $errCode = 4000;
}