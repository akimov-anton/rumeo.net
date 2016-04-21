<?php
/**
 * Created by PhpStorm.
 * User: Toha
 * Date: 21.04.2016
 * Time: 23:34
 */

namespace Api;

use Api\Base;

class VideoStats extends Base
{
    public function increment($video_id)
    {
        $video_stat = $this->getStatByVideoId($video_id);
        if ($video_stat) {
            $counter = $video_stat['counter'] + 1;
            $pattern = 'UPDATE `video_stats` SET `counter` = ?i WHERE `video_id` = ?i';
            $this->db->query($pattern, [$counter, $video_id]);
        }
        else{
            $pattern = 'INSERT INTO `video_stats` SET `counter` = ?i,`video_id` = ?i';
            $this->db->query($pattern, [1, $video_id]);
        }
    }

    protected function getStatByVideoId($video_id)
    {
        $pattern = 'SELECT * FROM `video_stats` WHERE video_id = ?scalar';
        $res = $this->db->query($pattern, [$video_id])->row();

        return $res;
    }

}