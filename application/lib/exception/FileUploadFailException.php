<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/4 0004
 * Time: 上午 9:19
 */

namespace app\lib\exception;


class FileUploadFailException extends BaseException
{
    public $code = 400;
    public $msg = '文件上传失败';
    public $errCode = 3001;
}