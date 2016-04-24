<?

//$c = имя контроллера, имя модели
//$url = урл этого объекта (страница,статья,категория...)

if (isset($_GET['c']))
{
    $c = $_GET['c'];
	
	if (isset($_GET['id'])) $id = $_GET['id']; else $id = 0;
	
	$find = (explode('_',$c));
}
else{ $c = 'Admin'; $id = 1; $find[0] = 'Admin'; }

if ($_GET) {$gets .=  '.'.http_build_query($_GET);}//ОПРЕДЕЛЕНИЕ GET переменных в строку

/*=======================================================================
Получем кеш файлы блоков или создаем их с помощью одноименных контроллеров
=======================================================================*/
require_once 'models/admin/Settings_model.php'; $sets = get_settings($control); //Подключаем модель для получения настроек и вытаскиваем
require_once 'models/admin/Get_tpl_model.php';//Модель для получения шаблонов (область <head>, блоки, контент)

$name_array = array('Header','Footer',$c,'Head');//Имена шаблонов

$tpl_array = get_tpl_admin($sets,$name_array,$gets,$id,$find,$c,$control);

$Header = $tpl_array[0];//Шапка (неизменный шаблон)
$Footer = $tpl_array[1];//Футер (неизменный шаблон)
$Content = $tpl_array[2];//Контент
$Head = $tpl_array[3];//Область <head>