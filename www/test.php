<?

//$start = microtime(true);
//date_default_timezone_set("Europe/Moskow");
$file = file_get_contents('controllers/admin/control.txt'); $control = unserialize($file);
include_once 'models/face/bd.php'; 
include_once 'models/face/Base_model.php'; 
//require_once 'classes/Page_Class.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Документ без названия</title>
<link href="views/face/themes/default/css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<? 

$res = mysql_query("SELECT id_p, cena, s_cena FROM my_cena");

if(!$res) die(mysql_error());

while($row = mysql_fetch_assoc($res))
{
	
	$up = mysql_query("UPDATE Product SET s_cena = '".$row['s_cena']."', cena = '".$row['cena']."' WHERE id = '".$row['id_p']."'");
}

?>
         

<?  ?>


</body>
</html>
<? //echo 'Время выполнения скрипта: '.round((microtime(true) - $start), 5).' сек.'; ?>