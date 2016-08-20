<?php

require __DIR__ . '/autoload.php';

//$db = \Elision\Orm\Model::getDbConnection();

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

use Elision\Helpers\Html;

echo Html::submitButton('Кнопка', ['class' => 'btn lol_new_class', 'id' => 'lol']);

$patern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';

$p = preg_match($patern, 'nomidkkfefef@dwdwdw.ru');

echo $p;
