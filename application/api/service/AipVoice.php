<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/4 0004
 * Time: 上午 10:33
 */

namespace app\api\service;

use app\lib\exception\VoiceException;
use think\Loader;

Loader::import('Aip/sdk/AipSpeech', EXTEND_PATH , '.php');
class AipVoice
{
    private $voice;

    public function __construct()
    {
        $this->voice = new \AipSpeech(config('AipConfig.APP_ID'), config('AipConfig.API_KEY'), config('AipConfig.SECRET_KEY'));
    }

    public function voice($filename){
        $file = file_get_contents($filename);
        if(!$file){
            throw new VoiceException([]);
        }
        $request = $this->voice->asr($file, 'pcm', 16000);
        return $request;
    }
}