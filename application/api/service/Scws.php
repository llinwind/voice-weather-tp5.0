<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/3 0003
 * Time: 上午 8:58
 */

namespace app\api\service;


class Scws
{
    private $scws = null;

    public function __construct()
    {
        $this->scws = scws_open();
        scws_set_charset($this->scws, "utf8");
//        scws_set_dict($this->scws, ini_get('scws.default.fpath') . '/dict.utf8.xdb');
        scws_set_dict($this->scws, ini_get('scws.default.fpath') . '/myDict.xdb');
//        scws_add_dict($this->scws, '/home/voice/www/myDict.txt',SCWS_XDICT_TXT);
        scws_set_rule($this->scws, ini_get('scws.default.fpath') . '/rules.ini');
//        scws_add_dict($this->scws, ini_get('scws.default.fpath') . '/dict.utf8.xdb');
        scws_set_multi($this->scws, SCWS_MULTI_SHORT);
        scws_set_ignore($this->scws, true);
    }

    public function scwsSeparate($text){
        if(empty($text))
            return [];
        scws_send_text($this->scws, $text);
        $scws = array();
        while ($res = scws_get_result($this->scws))
        {
            foreach ($res as $tmp)
            {
                if ($tmp['len'] == 1 && $tmp['word'] == "\r")
                    continue;
                if ($tmp['len'] == 1 && $tmp['word'] == "\n")
                    $scws[] = $tmp['word'];
                else
                    $scws[] = $tmp['word'];
            }
        }

        return $scws;
    }

    public function __destruct()
    {
        scws_close($this->scws);
    }
}
