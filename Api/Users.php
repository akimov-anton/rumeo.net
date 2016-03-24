<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.03.16
 * Time: 1:57
 */

namespace Api;


class Users extends Base
{
    public function login($login, $pass, $remote = 0)
    {

        $hash = md5(md5($login . ':' . $pass));

        $sql = 'SELECT `pass`,`id`,`role` FROM `users` WHERE `name`=?string';
        $userInfo = $this->db->query($sql, [$login])->row();
//        $sql = sprintf($sql, iesc($login));

//        $userInfo = ifetch_row_ac(iquery('prtnr-sel', $sql));

        $result = [];

        if ($userInfo && $userInfo['pass'] == $hash) {
            $ua_hash = md5($_SERVER['HTTP_USER_AGENT'] . 'Gjrtvjy');
            $hash = md5(md5($login . $ua_hash)) . sprintf('%04d', $userInfo['id']);

//            $role = $this->getRoleById($pass['role']);

//            $included = [];
//            $included[] = [
//                'id' => $role['data']['id'],
//                'type' => $role['data']['type'],
//                'attributes' => $role['data']['attributes'],
//            ];
//            unset($role['data']['relationships']);
//            unset($role['data']['attributes']);


            //setcookie('pm:moevideo:user',$hash,time()+60*60*24*7,'/');
            $result['data'] = [
                'id' => $userInfo['id'],
                'type' => 'user',
                'attributes' => [
                    'id' => $userInfo['id'],
                    'name' => $login,
                    'hash' => $hash,
                    'role' => $userInfo['role']
                ],
//                'relationships' => [
//                    'role' => [
//                        'data' => $role['data']
//                    ]
//                ]
            ];
//            $result['included'] = $included;
//            var_dump($result);
//            die();
            return $result;
        } else {
            header('HTTP/1.0 400');
            return [
                'errors' => [
                    'common' => 'Неправильный пароль или логин',
                ]
            ];
        }
    }

    public function getById($id)
    {
        $sql = 'SELECT * FROM `users` WHERE id = ?scalar';
        $userInfo = $this->db->query($sql, [$id])->row();

        return ['data' => [
            'id' => $userInfo['id'],
            'type' => 'user',
            'attributes' => [
                'id' => $userInfo['id'],
                'name' => $userInfo['name'],
                'role' => $userInfo['role']
            ]
        ]
        ];
    }
}