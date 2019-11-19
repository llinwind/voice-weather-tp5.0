<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/3 0003
 * Time: 上午 11:09
 */

namespace app\api\service;


class Weather
{
    public function getDaysWeather($city_code){

        $url = sprintf(config('setting.days_weather_url'), $city_code);
        $rs = https_request($url);
        $rs = preg_replace(array('/<head>([\s\S]+?)<\/head>/i','/<p>/i'),array('<head><meta http-equiv="Content-Type" content="text/html;charset=utf-8"></head>','<br><p>'),$rs);
        $dom = new \DOMDocument('2.0','utf-8');
        @$dom->loadHTML($rs);
        $xpath = new \DOMXPath($dom);
        $nodeList = $xpath->query('//*[contains(@class, "skyid")]');
//        var_dump(count($nodeList));
        $result = [];
        $i = 1;
        foreach ($nodeList as $node) {
            $result['day'.$i] = $this->getDaysInfo($dom->saveHTML($node));
            $i++;
        }//var_dump($result);
        if(empty($result)){
            return null;
        }
        return $result;
    }

    private function getDaysInfo($info){
        $result = [];
        $dom = new \DOMDocument();
        $dom->loadHTML('<?xml encoding="UTF-8">' . $info);
        foreach ($dom->childNodes as $item)
        {
            if ($item->nodeType == XML_PI_NODE)
            {
                $dom->removeChild($item); // remove hack
            }
        }
        $dom->encoding = 'UTF-8';
        $xpath = new \DOMXPath($dom);
        $result[] = trim($xpath->evaluate('string(//h1)'));
        $result[] = trim($xpath->query('//p[@class="wea"]')->item(0)->nodeValue);
        $result[] = trim($xpath->query('//p[@class="tem"]/span')->item(0)->nodeValue)."/".trim($xpath->query('//p[@class="tem"]/i')->item(0)->nodeValue);
//        $result[] = trim($xpath->query('//p[@class="tem"]/i')->item(0)->nodeValue);
//    $result[] = trim($xpath->evaluate('string(//p[@class="win"]/em/span/@title)'));
//    $result[] = trim($xpath->evaluate('string(//p[@class="win"]/em/span[2]/@title)'));
//    $result[] = trim($xpath->evaluate('string(//p[@class="win"]/i)'));
        return $result;
    }

    public function getCurrentWeather($city_code){
        $url = sprintf(config('setting.current_weather_url'), $city_code);
        $rs = https_request($url);
//        $rs = file_get_contents("/home/www/weather.html");
        var_dump($rs);
        $rs = preg_replace(array('/<head>([\s\S]+?)<\/head>/i','/<p>/i'),array('<head><meta http-equiv="Content-Type" content="text/html;charset=utf-8"></head>','<br><p>'),$rs);
        $dom = new \DOMDocument('2.0','utf-8');
        @$dom->loadHTML($rs);
        $xpath = new \DOMXPath($dom);
        $nodeList = $xpath->query('//ul[@class="clearfix"]');
//        var_dump($nodeList->item(0));
        $result = null;
        foreach ($nodeList as $node) {
            $result = $this->getCurrentInfo($dom->saveHTML($node));
//            var_dump($dom->saveHTML($node));
            break;
        }
        return $result;
    }

    private function getCurrentInfo($info){
        $result = [];
        $i = 0;
        $dom = new \DOMDocument();
        $dom->loadHTML('<?xml encoding="UTF-8">' . $info);
        foreach ($dom->childNodes as $item)
        {
            if ($item->nodeType == XML_PI_NODE)
            {
                $dom->removeChild($item); // remove hack
            }
        }
        $dom->encoding = 'UTF-8';
        $xpath = new \DOMXPath($dom);
        $nodeList = $xpath->query('//li');
        foreach ($nodeList as $node){
            if($i == 0 || $i == 1) {
                $dom1 = new \DOMDocument('2.0','utf-8');
                @$dom1->loadHTML('<?xml encoding="UTF-8">' . $dom->saveHTML($node));
                $dom1->encoding = 'UTF-8';
                $xpath1 = new \DOMXPath($dom1);
                if($i == 0){
                    $result['day'] = trim($xpath1->evaluate('string(//h1)'));
                    $result['dayWeather'] = trim($xpath1->query('//p[@class="wea"]')->item(0)->nodeValue);
                    $result['dayTemperature'] = trim($xpath1->query('//p[@class="tem"]/span')->item(0)->nodeValue)."℃";
                }else{
                    $result['night'] = trim($xpath1->evaluate('string(//h1)'));
                    $result['nightWeather'] = trim($xpath1->query('//p[@class="wea"]')->item(0)->nodeValue);
                    $result['nightTemperature'] = trim($xpath1->query('//p[@class="tem"]/span')->item(0)->nodeValue)."℃";
                }

            }
            $i++;
        }

        return $result;
    }
}
