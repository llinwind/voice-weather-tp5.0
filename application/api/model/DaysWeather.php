<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/3 0003
 * Time: 下午 4:47
 */

namespace app\api\model;


class DaysWeather extends BaseModel
{
    protected $hidden = ['id', 'updateTime'];

    public function getDaysWeather($cityCode){
        $outTime = time() - config('setting.time_out');

        $daysWeather = self::where('cityCode', '=', $cityCode)
            ->where('updateTime', '>' ,$outTime)
            ->find();
        if($daysWeather == null){
            return null;
        }else{
            $result = [];
            for ($i = 1; $i < 8; $i ++){
                $result['day'.$i] = json_decode($daysWeather['day'.$i], true);
            }
            return $result;
        }
    }

    public function setDaysWeather($cityCode, $weatherInfo){
        if(self::isExistCityCode($cityCode)){
            self::updateDaysWeather($cityCode, $weatherInfo);
        }else{
            self::insertDaysWeather($cityCode, $weatherInfo);
        }
    }

    private static function updateDaysWeather($cityCode, $weatherInfo){
        self::update([
            'day1' => json_encode($weatherInfo['day1'], JSON_UNESCAPED_UNICODE),
            'day2' => json_encode($weatherInfo['day2'], JSON_UNESCAPED_UNICODE),
            'day3' => json_encode($weatherInfo['day3'], JSON_UNESCAPED_UNICODE),
            'day4' => json_encode($weatherInfo['day4'], JSON_UNESCAPED_UNICODE),
            'day5' => json_encode($weatherInfo['day5'], JSON_UNESCAPED_UNICODE),
            'day6' => json_encode($weatherInfo['day6'], JSON_UNESCAPED_UNICODE),
            'day7' => json_encode($weatherInfo['day7'], JSON_UNESCAPED_UNICODE),
            'updateTime' => time()
        ],
            [
                'cityCode' => $cityCode
            ]);
    }

    private static function insertDaysWeather($cityCode, $weatherInfo){
        self::create([
            'cityCode' => $cityCode,
            'day1' => json_encode($weatherInfo['day1'], JSON_UNESCAPED_UNICODE),
            'day2' => json_encode($weatherInfo['day2'], JSON_UNESCAPED_UNICODE),
            'day3' => json_encode($weatherInfo['day3'], JSON_UNESCAPED_UNICODE),
            'day4' => json_encode($weatherInfo['day4'], JSON_UNESCAPED_UNICODE),
            'day5' => json_encode($weatherInfo['day5'], JSON_UNESCAPED_UNICODE),
            'day6' => json_encode($weatherInfo['day6'], JSON_UNESCAPED_UNICODE),
            'day7' => json_encode($weatherInfo['day7'], JSON_UNESCAPED_UNICODE),
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
