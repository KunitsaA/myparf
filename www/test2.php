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

<style>
.block{
	margin:20px;
}
.block p{
	margin-bottom:10px;
}
</style>
</head>

<body>

<div class="block">
<? 

$res = mysql_query("SELECT t1.name, t2.name as t2name, t3.name as t3name FROM Product t1 LEFT JOIN Brands t2 ON t1.brand=t2.id LEFT JOIN Product_Cat t3 ON t1.cat=t3.id WHERE t1.brand='23' ORDER BY t1.name");

if(!$res) die(mysql_error());
$i=1;
while($row = mysql_fetch_assoc($res)):?>
   
   <p><?=$i?>&nbsp;&nbsp;&nbsp;бренд: <?=$row['t2name']?>; название: <?=$row['name']?>; категория: <?=$row['t3name']?></p>     

<? $i++; endwhile ?>
</div>

</body>
</html>
<? //echo 'Время выполнения скрипта: '.round((microtime(true) - $start), 5).' сек.'; ?>