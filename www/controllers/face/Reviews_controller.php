<?
$file = file_get_contents('control.txt'); $control = unserialize($file);
require_once $control['home'].'models/face/bd.php';

//$_POST['id'] = 7;
//$_POST['q'] = 7;
function AddComments($id,$q)//Функция для выборки дополнительных комментариев
{
	$limit = $q - 5;
	$res = mysql_query("SELECT * FROM reviews WHERE id_pr='".$id."' AND status='1' ORDER BY id DESC LIMIT ".$limit." OFFSET 5");
	if(!$res) die(mysql_error());
	
	while($row = mysql_fetch_assoc($res))
	{
		$return[] = $row;
	}
	
	return $return;
}

if($_POST)//Если есть обращение через POST, определяем переменные и вызываем функцию.
{
	foreach ($_POST as $key => $val) { $$key = intval($val); }
	$return = AddComments($id,$q);
}
//print_r($return);
echo json_encode($return);//Возвращаем массив с комментариями.