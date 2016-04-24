<?

$file = file_get_contents('control.txt'); $control = unserialize($file);
require_once $control['home'].'models/admin/bd.php';

function Add_Char($name,$measure)
{
	$res = mysql_query("INSERT INTO Char_Groups (name,measure) VALUES ('".$name."','".$measure."')");
	if(!$res) die(mysql_error());
	
	$return = mysql_insert_id();
	
	return $return;
}

if($_POST)
{
	$name = $_POST['name']; $measure = $_POST['measure']; $return = Add_Char($name,$measure);
}

echo json_encode($return);