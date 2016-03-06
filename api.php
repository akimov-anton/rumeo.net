<?php

header("Content-type: application/vnd.api+json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Allow, Content-Type");

require(__DIR__ . '/autoload.php');
\Api\autoloadRegister();

$request = $_SERVER['REQUEST_URI'];
//var_dump($request);
//die();
$exploded_request = explode('/', $request);
$objects = explode('?', $exploded_request[2]);
$object = $objects[0];
$id = null;
$res = [];
//if (count(explode('/', $request)) == 4) {
//    $id = explode('?', $exploded_request[3]);
//    $id = $id[0];
//}
$id = count(explode('/', $request)) == 4 ? explode('?', $exploded_request[3])[0] : null;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($object) {
            case 'videos':
                $obj = new \Api\Videos();
                if ($id)
                    $res = $obj->getById($id);
                else {
                    $res = $obj->get();
                }
                break;
            case 'video-categories':
                $obj = new \Api\VideoCategory();
                $res = $obj->getAll();
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
                $res = $obj->add([$attributes['content']]);
//                $pattern = 'INSERT INTO `videos` SET `content` = ?string';
//                $query_data = [$attributes['content']];
//                $db->query($pattern, $query_data);
                break;
        }
};

print(json_encode($res));