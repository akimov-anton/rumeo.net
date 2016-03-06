<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.03.16
 * Time: 22:24
 */

namespace Api;

use Api\Base;

class VideoCategory extends Base
{
    public function getAll(){
        $res = [];
        $pattern = 'SELECT * FROM `video_categories`';
        $rows = $this->db->query($pattern, [])->assoc();

        foreach ($rows as $row) {
            $res['data'][] = [
                'id' => $row['id'],
                'type' => 'video-category',
                'attributes' => [
                    'name' => $row['name']
                ]
            ];
        }
        return $res;
    }

}