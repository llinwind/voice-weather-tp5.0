<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/31 0031
 * Time: 下午 3:21
 */

namespace app\api\model;


class WeatherCode extends BaseModel
{
    protected $hidden = ['id'];

    public function getCityID($cityName){
        return self::where('cityName', 'in', $cityName)
            ->find();
    }
}