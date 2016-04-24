<?

$error_msg = 'Delivery_List_controller';
if($_POST)
{
	$arr = $Object->Handle_Data($_POST);                    //Обработка данных перед использованием
	
	$Object->Delete($arr['id'],$error_msg.' function DELETE',$type);
	header("Location: ".$_SERVER['HTTP_REFERER']);          //Выход к исходной странице
	
	if($sets['cach']==1)
	{
		include_once "models/admin/Del_Cach_model.php";//Подключение модели для очистки кэш файлов
		$p = array(); $p[] = 'url=dostavka(Page)';
		DeletCach($control['home'],$p);
	}
	exit();//Завершаем работу скрипта
}

$data = $Object->Get_Array($error_msg.' data','Delivery','*','',' ORDER BY id DESC');

$html = includes('views/admin/themes/default/content_tpl/Delivery_List_content.php', array('data' => $data));