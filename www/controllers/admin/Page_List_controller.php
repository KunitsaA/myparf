<?

if($_POST)
{
	$arr = $Object->Handle_Data($_POST);                    //Обработка данных перед использованием
	
	$Object->Delete($arr['id'],$name.'_controller, function DELETE');
	header("Location: ".$_SERVER['HTTP_REFERER']);          //Выход к исходной странице
	
	if($sets['cach']==1)
	{
		include_once "models/admin/Del_Cach_model.php";//Подключение модели для очистки кэш файлов
		$p = array(); $p[] = '(Header)'; $p[] = 'Main'; $p[] = '.c=Page';
		DeletCach($control['home'],$p);
	}
	exit();//Завершаем работу скрипта
}

$data = $Object->Get_Array($name.'_controller, data');

$set = $Object->Object_Settings($control['home'],$type);

$html = includes('views/admin/themes/default/content_tpl/'.$name.'_content.php', array('data' => $data, 'set' => $set));