<?php
/**
 * Created by PhpStorm.
 * User: Toha
 * Date: 27.02.2016
 * Time: 3:48
 */

namespace Api;

use Api\Base;

class Videos extends Base
{
    public function add($data){
        $pattern = 'INSERT INTO `videos` SET `content` = ?string';
        $id = $this->db->query($pattern, $data)->id();
        return [
          'data' => [
              'id' => $id,
              'type' => 'video',

          ]
        ];
//        var_dump($this->db->plainQuery('LAST_INSERT_ID()'));
    }
    public function getById($id){
        $pattern = 'SELECT * FROM `videos` WHERE id = ?scalar';
        $res = $this->db->query($pattern, [$id])->row();
        return [
            'data'=> [
                'id' => $id,
                'type' => 'video',
                'attributes' => [
                    'content' => $res['content']
                ]
            ]
        ];
//        var_dump($res);
//        die();
    }
    public function edit($params){
        $attributes = $params['attributes'];
        $id = $params['id'];
        $content = $attributes['content'];
        $pattern = 'UPDATE `videos` SET content = ?string WHERE id = ?scalar';
        $this->db->query($pattern, [$content, $id]);
        return $this->getById($id);
    }
}