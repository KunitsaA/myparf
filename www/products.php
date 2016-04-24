<?
$file = file_get_contents('controllers/face/control.txt'); $control = unserialize($file);
require_once $control['home'].'models/face/Base_model.php'; //Подключаем общую модель
include_once $control['home'].'models/face/bd.php';//Соединение с БД

$products = array_get('cat,brand,type,cena,s_cena',"Product WHERE status='1' and krym='1'",'products');

array_json2file($products,$control['home'].'controllers/face/products.txt');