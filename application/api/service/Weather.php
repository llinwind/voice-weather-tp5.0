<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/3 0003
 * Time: 上午 11:09
 */

namespace app\api\service;

require_once EXTEND_PATH.'simple_html_dom/autoload.php';

use voku\helper\HtmlDomParser;

class Weather
{
    public function getDaysWeather($city_code){

        $url = sprintf(config('setting.days_weather_url'), $city_code);
        $rs = https_request($url);
        $dom = HtmlDomParser::str_get_html($rs);
        $element = $dom->findOne('.c7d');
        $element = $element->findOne(".clearfix");
        return $this->getDaysInfo($element);
    }

    private function getDaysInfo($nodeList){
        $result = [];
        $i = 1;
        foreach ($nodeList as $node){
//            var_dump($node->findOne("h1")->innertext);
//            var_dump($node->findOne("p.wea")->innertext);
//            var_dump($node->findOne("p.tem>span")->innertext);
            if((!empty($node->findOne("h1")->innertext)) && (!empty($node->findOne("p.wea")->innertext))) {
                $arr = [];
                $arr[] = $node->findOne("h1")->innertext;
                $arr[] = $node->findOne("p.wea")->innertext;
                $arr[] = $node->findOne("p.tem>span")->innertext;
                $result['day'.$i] = $arr;
                $i++;
            }
        }

        return $result;
    }

    public function getCurrentWeather($city_code){
        $url = sprintf(config('setting.current_weather_url'), $city_code);
        $rs = https_request($url);
//        $rs = file_get_contents("/home/www/weather.html");
        $dom = HtmlDomParser::str_get_html($rs);
        $element = $dom->findOne('.t');
        $element = $element->findOne(".clearfix");
        $element = $element->find("li");
        return $this->getCurrentInfo($element);
    }

    private function getCurrentInfo($nodeList){
        $result = [];
        $i = 0;
        foreach ($nodeList as $node){
            if((!empty($node->findOne("h1")->innertext)) && (!empty($node->findOne("p.wea")->innertext))){
                if($i == 0){
                    $result['day'] = trim($node->findOne("h1")->innertext);
                    $result['dayWeather'] = trim($node->findOne("p.wea")->innertext);
                    $result['dayTemperature'] = trim($node->findOne("p.tem>span")->innertext)."℃";
                }else if($i == 1){
                    $result['night'] = trim($node->findOne("h1")->innertext);
                    $result['nightWeather'] = trim($node->findOne("p.wea")->innertext);
                    $result['nightTemperature'] = trim($node->findOne("p.tem>span")->innertext)."℃";
                }
                $i++;
            }
        }

        return $result;
    }
}
