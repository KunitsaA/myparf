<?

$file = file_get_contents('control.txt'); $control = unserialize($file);
require_once $control['home'].'models/admin/bd.php';

function Add($name)
{
	$res = mysql_query("INSERT INTO Brands (name) VALUES ('".$name."')");
	if(!$res) die(mysql_error());
	
	$return = mysql_insert_id();
	
	return $return;
}

if($_POST)
{
	$name = $_POST['name']; $return = Add($name);
}

echo json_encode($return);