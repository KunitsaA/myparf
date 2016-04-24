<?
function SaveControl($arr,$filename)
{
	$str_value = serialize($arr); $f = fopen($filename, 'w'); fwrite($f, $str_value); fclose($f);
}

if($_POST)
{
	$_POST = array_map("utf8_encode",$_POST);
	$dir = $_POST['home'];
	$file = 'control.txt';
	
	$dirs = array(); $file_name = 'control.txt';
	$dirs[] = 'controllers/face/';
	$dirs[] = 'controllers/admin/';
	$dirs[] = 'models/face/';
	$dirs[] = 'models/admin/';
	$count_dirs = count($dirs);
	
	for($i=0; $i<$count_dirs; $i++)
	{
		SaveControl($_POST,$dir.$dirs[$i].$file);//Записываем настройки в файл
	}
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Конфиг Контроллер</title>
</head>

<body>

<form action="" method="post">

<label>Домашняя директория: <input name="home" required type="text" value="<?=$_SERVER[DOCUMENT_ROOT]?>/"></label><br>
<label>Хост: <input name="host" required type="text" value="<?=$_SERVER[HTTP_HOST]?>"></label><br>
<label>Хост БД: <input name="db_host" required type="text"></label><br>
<label>Логин БД: <input name="db_login" required type="text"></label><br>
<label>Пароль БД: <input name="db_pass" required type="text"></label><br>
<label>Имя БД: <input name="db_name" required type="text"></label><br>
<input type="submit" value="Отправить"><br>

</form>

</body>
</html>