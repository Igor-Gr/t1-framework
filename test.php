<?php

require __DIR__ . '/autoload.php';

$db = \Elision\Orm\Model::getDbConnection();

/*class User {

}

$a = $db->query('SELECT * FROM users', 'User');
var_dump($a);*/

/*var_dump($db->getDriver());*/

/*$a = [
    '__id' => ['type' => 'pk'],
    'time' => ['type' => 'int']
];

foreach ($a as $k => $v) {
    echo $k;
}*/

new Elision\Commands\Application();




