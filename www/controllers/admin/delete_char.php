<?
$file = file_get_contents('control.txt'); $control = unserialize($file);
require_once $control['home'].'models/admin/bd.php';
require_once $control['home'].'models/admin/Settings_model.php'; $sets = get_settings($control); //Подключаем модель для получения настроек и вытаскиваем

function Up_Cahars_Cats($id,$cat,$index)
{
	$res=mysql_query("SELECT cat FROM Char_Groups WHERE id='".$id."'");
	if(!$res) die(mysql_error());
	
	$row = mysql_fetch_assoc($res);
	
	$row['cat'] = explode(',',$row['cat']); $row['cat'] = array_filter($row['cat']); $count_r = count($row['cat']); 
	
	for($i=0; $i<$count_r; $i++){ if($cat == $row['cat'][$i]) { unset($row['cat'][$i]); break; } }
	
	$row['cat'] = implode(',',$row['cat']);
	
	$up = mysql_query("UPDATE Product SET char".$index."='' WHERE cat='".$cat."'");
	if(!$up) die(mysql_error());
	
	$res2 = mysql_query("UPDATE Char_Groups SET cat='".$row['cat']."' WHERE id='".$id."'");
	if(!$res2) die(mysql_error());
	
	return $res2;
}

if($_POST)
{
	$id = $_POST['id']; $cat = $_POST['cat']; $index = $_POST['index']; $return = Up_Cahars_Cats($id,$cat,$index);
	
	if($sets['cach']==1){
			include_once $control['home'].'models/admin/Del_Cach_model.php';//Подключение модели для очистки кэш файлов
			AllDeletCach($control['home']);
		}
}
echo json_encode($return);