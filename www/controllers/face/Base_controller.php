<?
require_once $control['home'].'models/face/view.php';//Подключение шаблонов
//$c = имя контроллера, имя модели
//$url = урл этого объекта (страница,статья,категория...)
if (isset($_GET['url']))
{
	if (isset($_GET['id']))  $id = $_GET['id'];
	if (isset($_GET['url'])) $url = $_GET['url'];
	if (isset($_GET['c']))   $c = $_GET['c'];
	
	$find = (explode('_',$c));
}
else{ $url = ''; $c = 'Page'; $id = 1; $find[0] = 'Page'; }

require_once $control['home'].'models/face/Settings_model.php'; $sets = get_settings($control); //Подключаем модель для получения настроек и вытаскиваем

if ($_GET) {$gets .=  '.'.http_build_query($_GET);}//ОПРЕДЕЛЕНИЕ GET переменных в строку

//echo '<tt><pre>'; print_r($_SERVER); echo '</tt></pre>';

/*=======================================================================
Получем кеш файлы блоков или создаем их с помощью одноименных контроллеров
=======================================================================*/

require_once $control['home'].'models/face/Get_tpl_model.php';//Модель для получения шаблонов (область <head>, блоки, контент)

$name_array = array('Header','Footer','Catalog_Menu',$c,'Head');//Имена шаблонов

$tpl_array = get_tpl($sets,$name_array,$gets,$id,$find,$c,$control,$url);

$Header = $tpl_array[0];//Шапка (неизменный шаблон)
$Footer = $tpl_array[1];//Футер (неизменный шаблон)
$Catalog_Menu = $tpl_array[2];//Меню каталога
$Content = $tpl_array[3];//Контент
$Head = $tpl_array[4];//Область <head>
//unset($tpl_array,$sets);

/*=======================================================================
                  Поключение общего шаблона страницы
========================================================================*/
$tpl = includes($control['home'].'views/face/themes/default/index_tpl.php', array('Head' => $Head, 'Header' => $Header, 'Catalog_Menu' => $Catalog_Menu, 'Content' => $Content, 'Footer' => $Footer, 'c' => $c, 'id' => $id, 'page' => $page));//Сборка всех данных в шаблон страницы
echo $tpl;//Вывод страницы на экран