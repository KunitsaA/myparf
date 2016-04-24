<?
$file = file_get_contents('controllers/face/control.txt'); $control = unserialize($file);
require_once 'models/admin/bd.php';
require_once 'models/admin/Base_model.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Документ без названия</title>
</head>

<body>

<?

$res = mysql_query("SELECT id FROM Product WHERE cat='24'");
if(!$res) die(mysql_error());

$return = array();

while($row = mysql_fetch_assoc($res))
{
	$return[] = $row['id'];
}

$update = implode(',',$return);

$to_rows = update('Product',"cat='2' WHERE id IN (".$update.")");

echo $update;



?>

</body>
</html>