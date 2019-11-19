<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/31 0031
 * Time: 上午 10:22
 */

namespace app\api\controller\v1;


use app\api\model\CurrentWeather;
use app\api\model\DaysWeather;
use app\api\model\WeatherCode;
use app\api\service\AipVoice;
use app\api\service\FileUpload;
use app\api\service\Weather as ServiceWeather;
use app\api\service\Scws;
use app\api\validate\CityNameValidate;
use app\lib\exception\CityNameMissException;
use app\lib\exception\ParameterException;
use app\lib\exception\VoiceException;
use app\lib\exception\WeatherMissException;
use think\Controller;

class Weather extends Controller
{
    public function getCurrentWeather($cityName){
        (new CityNameValidate())->goCheck();

        $city = self::getCityCode($cityName);
        $cityCode = $city['cityCode'];

        $currentWeather = new CurrentWeather();
        $weather = $currentWeather->getCurrentWeather($cityCode);
        if($weather != null){
            return $weather;
        }

        $serviceWeather = new ServiceWeather();
        $weather = $serviceWeather->getCurrentWeather($cityCode);
        if($weather == null){
            throw new WeatherMissException([]);
        }
        $currentWeather->setCurrentWeather($cityCode, $weather);
        $weather['cityCode'] = $cityCode;
        return $weather;
    }

    public function getDaysWeather($cityName){
        (new CityNameValidate())->goCheck();

        return self::getCityDaysWeather($cityName);
    }

    public function voiceWeather(){
        $file = (new FileUpload())->fileUpload();
        $fileSaveName = ROOT_PATH.'/uploads/'.$file->getSaveName();
        $filePcmName = ROOT_PATH.'/uploads/'.$file->getSaveName().'.pcm';
        $cmd = sprintf(config('ffmpeg.shell'), $fileSaveName, $filePcmName);
        exec($cmd);
        $voice = new AipVoice();
        $text = $voice->voice($filePcmName);//return $text['result'][0];
        if($text['err_no'] != 0){
            throw new VoiceException([]);
        }
        return self::getCityDaysWeather($text['result'][0]);
    }

    private static function getCityDaysWeather($cityName){
        $city = self::getCityCode($cityName);
        $cityCode = $city['cityCode'];
        $cityName = $city['cityName'];

        $daysWeather = new DaysWeather();
        $weather = $daysWeather->getDaysWeather($cityCode);
        if($weather != null){
            $weather['cityName'] = $cityName;
            return $weather;
        }

        $serviceWeather = new ServiceWeather();
        $weather = $serviceWeather->getDaysWeather($cityCode);
        if($weather == null){
            throw new WeatherMissException([]);
        }
        $daysWeather->setDaysWeather($cityCode, $weather);
        $weather['cityName'] = $cityName;
        return $weather;
    }

    private static function getCityCode($cityName){
        $scws = new Scws();
        $scwsArr = $scws->scwsSeparate($cityName);
        if(empty($scwsArr)){
            throw new CityNameMissException([]);
        }

        $weatherCode = new WeatherCode();
        $city = $weatherCode->getCityID($scwsArr);
        if($city == NULL){
            throw new CityNameMissException([]);
        }
        $cityCode = $city['cityCode'];
        $cityName = $city['cityName'];
        if(empty($cityCode)){
            throw new CityNameMissException([]);
        }
        return [
            'cityCode' => $cityCode,
            'cityName' => $cityName
        ];
    }
}
