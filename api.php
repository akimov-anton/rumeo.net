<?php

header("Content-type: application/vnd.api+json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Allow, Content-Type");

require(__DIR__ . '/autoload.php');
\Api\autoloadRegister();

$request = $_SERVER['REQUEST_URI'];

if (!empty($_GET['login']) && !empty($_GET['pass'])) {
    $obj = new Api\Users();
    $res = $obj->login($_GET['login'], $_GET['pass']);
} else {
    $exploded_request = explode('/', $request);
    $objects = explode('?', $exploded_request[2]);
    $object = $objects[0];
    $id = null;
    $res = [];
    $id = count(explode('/', $request)) == 4 ? explode('?', $exploded_request[3])[0] : null;
    $params = $_GET;
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            switch ($object) {
                case 'videos':
                    $obj = new \Api\Videos();
                    if ($id)
                        $res = $obj->getById($id);
                    else {
                        if (!empty($params['top']))
                            $res = $obj->getTopVideos();
                        else
                            $res = $obj->get($params);
                    }
                    break;
                case 'video-categories':
                    if ($id) {
                        $obj = new \Api\VideoCategory();
                        $res = $obj->getById($id);
                    } else {
                        $obj = new \Api\VideoCategory();
                        $res = $obj->getAll();
                    }
                    break;
                case 'users':
                    $obj = new Api\Users();
                    $res = $obj->getById($id);
                    break;
            }
            break;
        case 'PATCH':
            $entityBody = file_get_contents('php://input');
            $fields = json_decode($entityBody, true);
            $data = $fields['data'];

            switch ($object) {
                case 'videos':
                    $obj = new \Api\Videos();
                    $res = $obj->edit($data);
                    break;
            }
            break;
        case 'POST':
            $entityBody = file_get_contents('php://input');
            $fields = json_decode($entityBody, true);
            $data = $fields['data'];
            $attributes = $data['attributes'];

            switch ($object) {
                case 'videos':
                    $obj = new \Api\Videos();
                    $res = $obj->add($data);
//                $pattern = 'INSERT INTO `videos` SET `content` = ?string';
//                $query_data = [$attributes['content']];
//                $db->query($pattern, $query_data);
                    break;
            }
    };
}


print(json_encode($res));