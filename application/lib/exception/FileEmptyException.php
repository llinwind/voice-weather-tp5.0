<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/4 0004
 * Time: 上午 9:39
 */

namespace app\lib\exception;


class FileEmptyException extends BaseException
{
    public $code = 400;
    public $msg = '文件不能为空';
    public $errCode = 3002;
}