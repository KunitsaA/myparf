<?
//$start = microtime(true);
$file = file_get_contents('controllers/face/control.txt'); $control = unserialize($file);
if(!is_array($control)) { echo 'Not plugged config file'; exit(); }

//$c = имя контроллера, имя модели
//$url = урл этого объекта (страница,статья,категория...)
if (isset($_GET['url']))
{
	$url = $_GET['url'];
	if (isset($_GET['id']))  $id = $_GET['id'];
	if (isset($_GET['c']))   $c = $_GET['c'];
	$find = (explode('_',$c));
}
else
{
	$url = ''; $c = 'Page'; $id = 1; $find[0] = 'Page';
}

$c_names = array('Page','Product_Cat','Product_Object','Article_Cat','Article_Object');
$cc_names = count($c_names); $match = 0;

for($i=0; $i<$cc_names; $i++) { if($c_names[$i]==$c) { $match += 1; } }

if($match>0)
{
	if(file_exists( 'prepared/'.$c.'_perform.php' )) include $control['home'].'prepared/'.$c.'_perform.php';
	else include $control['home'].'controllers/face/Base_controller.php';
}
else
{
	echo 'It was introduced false variable'; exit();//Перенаправляем на страницу ошибки или ...
}