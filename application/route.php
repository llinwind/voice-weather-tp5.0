<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::get('current_weather/:cityName', 'api/v1.Weather/getCurrentWeather');
Route::get('days_weather/:cityName', 'api/v1.Weather/getDaysWeather');
Route::post('voice_weather', 'api/v1.Weather/VoiceWeather');
Route::miss('api/Miss/miss');
