<?

$error_msg = 'Settings_controller';
if($_POST)
{
	
	$arr = $Object->Handle_Data($_POST); if($arr['pass']) $arr['pass'] = md5($arr['pass']); //Обработка данных перед использованием                   
	$Object->Update($arr,$error_msg.', data','Settings');
	unlink('models/face/settings.txt');
	header("Location: ".$_SERVER['HTTP_REFERER']);          //Выход к исходной странице
	
	include_once 'models/admin/Del_Cach_model.php';//Подключение модели для очистки кэш файлов
	AllDeletCach($control['home']);
	
	exit();//Завершаем работу скрипта
}


$data = $Object->Get_Object(1,$error_msg.', data','Settings');

$html = includes('views/admin/themes/default/content_tpl/Settings_content.php', array('data' => $data));