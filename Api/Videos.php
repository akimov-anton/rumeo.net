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
    public function add($params)
    {
        $attributes = $params['attributes'];
        $source = $attributes['source'];
        $relationships = $params['relationships'];

        $category = !empty($relationships['category']) ? $relationships['category']['data']['id'] : null;
        $pattern = 'INSERT INTO `videos` SET `content` = ?string, `category_id` = ?i';
        $id = $this->db->query($pattern, [$source, $category])->id();
        return $this->getById($id);
//        var_dump($this->db->plainQuery('LAST_INSERT_ID()'));
    }

    public function getById($id)
    {
        $pattern = 'SELECT * FROM `videos` WHERE id = ?scalar';
        $res = $this->db->query($pattern, [$id])->row();

        $result['included'][] = [
            'id' => $res['category_id'],
            'type' => 'video-category',
        ];

        return [
            'data' => [
                'id' => $id,
                'type' => 'video',
                'attributes' => [
                    'source' => $res['content']
                ],
                'relationships' => [
                    'category' => [
                        'data' => [
                            'id' => $res['category_id'],
                            'type' => 'video-category'
                        ]
                    ]
                ]
            ]
        ];
//        var_dump($res);
//        die();
    }

    public function get($params)
    {
        $res = [];
        $where = ['1=1'];
        $category = $params['category'];
        if (!empty($category)) {
            $where[]= '`category_id` = ' . $category;
        }
        $where = join(' AND ', $where);
        $pattern = 'SELECT * FROM `videos` WHERE ' . $where . ' LIMIT 10';
        $rows = $this->db->query($pattern, [])->assoc();
//        var_dump($res);
//        die();
        foreach ($rows as $row) {
            $res['data'][] = [
                'id' => $row['id'],
                'type' => 'video',
                'attributes' => [
                    'source' => $row['content']
                ]
            ];
        }
        return $res;
    }

    public function edit($params)
    {
        $attributes = $params['attributes'];
        $relationships = $params['relationships'];
        $category = $relationships['category'] ? $relationships['category']['data']['id'] : null;
        $id = $params['id'];
        $content = $attributes['source'];
        $pattern = 'UPDATE `videos` SET content = ?string, category_id = ?i WHERE id = ?scalar';
        $this->db->query($pattern, [$content, $category, $id]);
        return $this->getById($id);
    }
}