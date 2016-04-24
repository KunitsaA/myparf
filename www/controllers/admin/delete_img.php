<? 
$file = file_get_contents('control.txt'); $control = unserialize($file);
require_once $control['home'].'models/admin/bd.php';
require_once $control['home'].'models/admin/Settings_model.php'; $sets = get_settings($control); //Подключаем модель для получения настроек и вытаскиваем

/*================================================================*/
function deleteImg($arr,$id,$ims,$imr,$img,$tab,$control)//$par,$par2,
	{
		$set = ''; for($i=1; $i<=10; $i++){ $set .= ($i==10) ? " img".$i."='', ims".$i."='', imr".$i."=''" : " img".$i."='', ims".$i."='', imr".$i."='',"; }
		
		$res = mysql_query("UPDATE ".$tab." SET ".$set." WHERE id='".$id."'");
		if(!$res) die (mysql_error());
		
		unlink($control['home'].$ims); unlink($control['home'].$img); unlink($control['home'].$imr);
		
		$cnt = count($arr);$up = '';
		
		if($cnt>0)
		{
			for ($i=0; $i<$cnt; $i++)
			{
				$a = $i+1;
				$up .= ($i==0) ? "img".$a."='".$arr[$i][0]."', ims".$a."='".$arr[$i][1]."', imr".$a."='".$arr[$i][2]."'" : ", img".$a."='".$arr[$i][0]."', ims".$a."='".$arr[$i][1]."', imr".$a."='".$arr[$i][2]."'";
				
			}		
			$res2 = mysql_query("UPDATE ".$tab." SET ".$up." WHERE id='".$id."'");
			if(!$res2) die (mysql_error());
			return $res2;
		}
		else
		{
			return $res;
		}	
	}
/*================================================================*/


if($_POST)
{
	
		$id = $_POST['id']; $arr = $_POST['arr']; $ims = $_POST['ims']; $img = $_POST['img']; $imr = $_POST['imr']; $tab = $_POST['tab'];
		$return = deleteImg($arr,$id,$ims,$imr,$img,$tab,$control);
		
		if($sets['cach']==1){
			include_once $control['home'].'models/admin/Del_Cach_model.php';//Подключение модели для очистки кэш файлов
			$p = array(); $p[] = '.c=Product_Cat'; $p[] = '.c=Product_Object'; $p[] = 'Main(Page)';
			DeletCach($control['home'],$p);
		}
							   
}
echo json_encode($control['home'].'_'.$return);