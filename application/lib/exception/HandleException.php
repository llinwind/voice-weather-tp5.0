<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/31 0031
 * Time: 上午 10:55
 */

namespace app\lib\exception;


use think\exception\Handle;
use think\Request;
use think\Log;

class HandleException extends Handle
{
    private $code;
    private $msg;
    private $errCode;
    public function render(\Exception $e){
        if($e instanceof BaseException){
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errCode = $e->errCode;
        }
        else{
            $this->code = 500;
            $this->msg = '服务器内部错误'.$e->getMessage().$e->getFile().$e->getLine();
            $this->errCode = 999;
            $this->renderErrorLog($e);
        }
        $result = [
            'errCode' => $this->errCode,
            'msg' => $this->msg,
            'request_url' => Request::instance()->url(),
        ];
        return json($result, $this->code);
    }

    private function renderErrorLog(\Exception $e){
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error']
        ]);
        Log::record($e->getMessage(),'error');
    }

}
