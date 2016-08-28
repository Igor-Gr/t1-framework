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

/*$data = explode('|','25-1|98-1|89-2|13-2|6-1|180-2|33-1|32-1');
foreach($data as $a) {
    $v = explode('-',$a);
    $res[array_shift($v)] = array_pop($v);
}
print_r($res);*/

/*$user = new \protect\Models\User();
$user->email = 'Ighrfffffffffthror';
$user->password = '24dddfffff23hthr82';*/

/*$sign = new \protect\Models\Signup();

$sign->validate();*/

/*class MyError
{

    public $errors = [];

    public function showErrors(){
        return array_shift($this->errors);
    }
}



$err = new MyError();
$err->errors[] = 'lol';
$err->errors[] = 'lol1';

echo $err->showErrors();*/

/*$str = "Логин не должен превышать @ символов";
$a = 5;

$newStr = str_replace("@", $a, $str);
echo $newStr;*/

/*use Elision\Helpers\Html;

echo Html::submitButton('Кнопка', ['class' => 'btn lol_new_class', 'id' => 'lol']);*/

// v$user->find()->asArray()->where(['id' => '25'])->all();


/*$user = new \protect\Models\Users();


$user2 = $user->find()->where(['id' => 1])->all();

var_dump($user2);
echo "<br>";

$user2->login = 'qwerty';

var_dump($user);*/


/*$user = \protect\Models\Users::find()->where(['id'=>1])->all();

var_dump($user);*/

/*$start = microtime(true);
for ($i = 0; $i < 99999999; $i++) {

}
$time = microtime(true) - $start;
printf('Скрипт выполнялся %.4F сек.', $time);

echo "<br>";

echo memory_get_usage() . ' байт';*/

/*$user = new \protect\Models\Users();

$user->login = 'fwefegfw';
$user->email = 'fweregfw';

$user->update(['id'=>3]);*/

/*$user = new \protect\Models\Users();

var_dump($user->findOne(['id'=>1]));*/

/*$conf = \Elision\Core\Config::getConfig();

echo $conf->url;*/

//var_dump(\Elision\Web\Images::joinImg('files/19f8ab34_001.jpg', 'files/19f8ab34_001.jpg'));

$conf = new \protect\Models\Config();

$conf->update(['id'=>1]);













