<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/4 0004
 * Time: 上午 10:22
 */

namespace app\api\service;


use app\lib\exception\FileEmptyException;
use app\lib\exception\FileUploadFailException;


class FileUpload
{
    public function fileUpload($name = 'file', $path = '../uploads', $savename = ''){
        $file = request()->file($name);
        if(empty($file)){
            throw new FileEmptyException([]);
        }
        $info = $file->validate(['ext' => 'mp3, MP3'])->move($path, $savename);
        if($info){
            return $info;
        }else{
            throw new FileUploadFailException([]);
        }
    }
}