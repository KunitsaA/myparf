<?
$file = file_get_contents('control.txt'); $control = unserialize($file);
require_once $control['home'].'models/face/bd.php';
require_once $control['home'].'models/face/Base_model.php';

function Get_Capcha()
{
	$res = mysql_query("SELECT * FROM capcha ORDER BY RAND() LIMIT 4");
	if(!$res) die(mysql_error());
	
	$return = array();
	
	while($row=mysql_fetch_assoc($res))
	{
		$return[]=$row;
	}
	
	return $return;
}

$return = Get_Capcha();
echo json_encode($return);