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
    private function getYoutubeTitle($video_id)
    {
        $html = file_get_contents("http://www.youtube.com/watch?v=$video_id");
        $dom = new \DOMDocument();
        $ies = libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">' . $html);
        libxml_use_internal_errors($ies);
        return $dom->getElementById('eow-title')->nodeValue;
    }

    public function add($params)
    {
        $attributes = $params['attributes'];
        $source = $attributes['source'];
        $relationships = $params['relationships'];
        $hash = $attributes['youtube-hash'];
        $title = '';
        if ($hash) {
            $title = $this->getYoutubeTitle($hash);
        }

        $category = !empty($relationships['category']) ? $relationships['category']['data']['id'] : null;
        $pattern = 'INSERT INTO `videos` SET `content` = ?string, `category_id` = ?i, title = ?string';
        $id = $this->db->query($pattern, [$source, $category, $title])->id();
        return $this->getById($id);
//        var_dump($this->db->plainQuery('LAST_INSERT_ID()'));
    }

    public function getById($id)
    {
        $video_stats = new VideoStats();
        $video_stats->increment($id);

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
                    'source' => $res['content'],
                    'title' => $res['title']
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
        $page = !empty($params['page']) && is_numeric($params['page']) ? $params['page'] : 1;
        $limit = !empty($params['limit']) && is_numeric($params['limit']) ? $params['limit'] : 10;
        $offset = is_numeric($limit) && is_numeric($page) ? ($page - 1) * $limit : 0;
        $where = ['1=1'];
        $category = $params['category'];
        if (!empty($category)) {
            $where[] = '`category_id` = ' . $category;
        }
        $where = join(' AND ', $where);
        $pattern = 'SELECT * FROM `videos` WHERE ' . $where . ' LIMIT ?i, ?i';
//        var_dump($pattern);
//        die();
        $rows = $this->db->query($pattern, [$offset, $limit])->assoc();
//        var_dump($res);
//        die();
        foreach ($rows as $row) {
            $res['data'][] = [
                'id' => $row['id'],
                'type' => 'video',
                'attributes' => [
                    'source' => $row['content'],
                    'title' => $row['title']
                ]
            ];
        }
        return $res;
    }

    public function getTopVideos()
    {
        $res = [];
        $where = ['1=1'];
        $where = join(' AND ', $where);
        $pattern = 'SELECT * FROM `videos` WHERE ' . $where . ' LIMIT 12';
        $rows = $this->db->query($pattern, [])->assoc();
//        var_dump($res);
//        die();
        foreach ($rows as $row) {
            $res['data'][] = [
                'id' => $row['id'],
                'type' => 'video',
                'attributes' => [
                    'source' => $row['content'],
                    'title' => $row['title']
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
        $hash = $attributes['youtube-hash'];
        $title = null;
        if ($hash) {
            $title = $this->getYoutubeTitle($hash);
        }
        $pattern = 'UPDATE `videos` SET content = ?, category_id = ?i, `title` = ? WHERE id = ?scalar';
        $this->db->query($pattern, [$content, $category, $title, $id]);
        return $this->getById($id);
    }
}