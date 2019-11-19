<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/31 0031
 * Time: 下午 1:30
 */

namespace app\api\validate;


class CityNameValidate extends BaseValidate
{
    protected $rule = [
        'cityName' => 'require'
    ];

    protected $message = [
        'cityName' => '城市名称不能为空'
    ];
}