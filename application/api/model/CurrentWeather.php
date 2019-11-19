<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/31 0031
 * Time: 下午 3:19
 */

namespace app\api\model;



class CurrentWeather extends BaseModel
{
    protected $hidden = ['id', 'updateTime'];

    public function getCurrentWeather($cityCode){
        $outTime = time() - config('setting.time_out');
        return self::where('cityCode', '=', $cityCode)
            ->where('updateTime', '>' ,$outTime)
            ->find();
    }

    public function setCurrentWeather($cityCode, $weatherInfo){
        if(self::isExistCityCode($cityCode)){
            self::updateCurrentWeather($cityCode, $weatherInfo);
        }else{
            self::insertCurrentWeather($cityCode, $weatherInfo);
        }
    }

    private static function updateCurrentWeather($cityCode, $weatherInfo){
        self::update([
                'day' => $weatherInfo['day'],
                'dayWeather' => $weatherInfo['dayWeather'],
                'dayTemperature' => $weatherInfo['dayTemperature'],
                'night' => $weatherInfo['night'],
                'nightWeather' => $weatherInfo['nightWeather'],
                'nightTemperature' => $weatherInfo['nightTemperature'],
                'updateTime' => time()
            ],
            [
                'cityCode' => $cityCode
            ]);
    }

    private static function insertCurrentWeather($cityCode, $weatherInfo){
        self::create([
            'cityCode' => $cityCode,
            'day' => $weatherInfo['day'],
            'dayWeather' => $weatherInfo['dayWeather'],
            'dayTemperature' => $weatherInfo['dayTemperature'],
            'night' => $weatherInfo['night'],
            'nightWeather' => $weatherInfo['nightWeather'],
            'nightTemperature' => $weatherInfo['nightTemperature'],
            'updateTime' => time()
        ]);
    }

    private static function isExistCityCode($cityCode){
        $result = self::where('cityCode', '=', $cityCode)
            ->find();
        if(isset($result)){
            return true;
        }else{
            return false;
        }
    }
}
