<?
$file = file_get_contents('control.txt'); $control = unserialize($file);
require_once $control['home'].'models/admin/bd.php';
require_once $control['home'].'models/admin/Settings_model.php'; $sets = get_settings($control); //Подключаем модель для получения настроек и вытаскиваем
require_once $control['home'].'models/admin/Base_model.php';
require_once $control['home'].'classes/Product_Class.php';

function Change_Status($tab,$id,$status)//Изменение статуса
{
	$res = mysql_query("UPDATE ".$tab." SET status='".$status."' WHERE id='".$id."'");
	
	if(!$res) { echo 'List_Ajax_controller function Chenge_Status <br>'; die(mysql_error()); }
	
	return $res;	
}

function Delete_Object($tab,$id)//Удаление объекта
{	                            
	$res = mysql_query("DELETE FROM ".$tab." WHERE id='".$id."'");
	
	if(!$res) { echo 'List_Ajax_controller function Delete_Object<br />'; die(mysql_error()); }	
	
	return $res;							
}

if($_POST)
{
	$Object = new Product();
	$arr = $Object->Handle_Data($_POST);// Обработка данных перед использованием
	
	if(isset($arr['status']))
	{
		$return = Change_Status($arr['tab'],$arr['id'],$arr['status']);
	}
	else
	{
		if($arr['tab']=='Product')
		{
			$Object->Delete_Images($control['home_dir'],$control['db_name'],$arr['tab'],$arr['id']);
			$return = $Object->Delete($arr['id'],'List_Ajax_controller, function DELETE',$arr['tab']);
		}
		else
		{
			$return = Delete_Object($arr['tab'],$arr['id']);
		}
	}
	if($sets['cach']==1){
			include_once $control['home'].'models/admin/Del_Cach_model.php';//Подключение модели для очистки кэш файлов
			AllDeletCach($control['home']);
		}
}
echo json_encode($return);