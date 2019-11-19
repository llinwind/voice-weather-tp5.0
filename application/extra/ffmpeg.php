<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/4 0004
 * Time: 下午 1:25
 */

return [
  'shell' => 'ffmpeg -y -i %s -acodec pcm_s16le -f s16le -ac 1 -ar 16000 %s'
];