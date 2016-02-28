<?php
/**
 * Created by PhpStorm.
 * User: Toha
 * Date: 27.02.2016
 * Time: 3:58
 */

namespace Api;

require(__DIR__ . '/../goDB/autoload.php');

class Base
{
    private $params = array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => 'video',
        'charset' => 'utf8',
//        '_debug' => true,
        '_prefix' => 'p_',
    );
    protected $db;

    function __construct(){
        \go\DB\autoloadRegister();
        $this->db = \go\DB\DB::create($this->params, 'mysql');
    }
}