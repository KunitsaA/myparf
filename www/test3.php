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

$res = mysql_query("SELECT id, cena, s_cena FROM Product");

if(!$res) die(mysql_error());

while($row = mysql_fetch_assoc($res))
{
	$cena = 0;
	$cena = $row['s_cena'] + ($row['s_cena']/8 * 2);
	
	//echo $row['cena'].' + ('.$row['cena'].' / 10 * 2) = '.$cena;
	
	$cena = ceil($cena/10) * 10;
	
	//echo ' окргл = '.$cena.' <br>'; 
	
	$res2 = mysql_query("INSERT INTO my_cena (id_p, cena, s_cena) VALUES ('".$row['id']."', '".$cena."', '".$row['s_cena']."')");
}

?>
         

<?  ?>


</body>
</html>
<? //echo 'Время выполнения скрипта: '.round((microtime(true) - $start), 5).' сек.'; ?>