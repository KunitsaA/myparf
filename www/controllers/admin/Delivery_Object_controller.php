<?
if($_POST)
{
	$arr = $Object->Handle_Data($_POST); $refer = $arr['refer']; unset($arr['refer']);

	if($_POST['id'])
	{
		$Object->Update($arr,$name.'_controller, update',$type);   //Редактирование строки
		header("Location: ".$refer);           //Выход к списку страниц
		if($sets['cach']==1)
		{
			include_once "models/admin/Del_Cach_model.php";//Подключение модели для очистки кэш файлов
			$p = array(); $p[] = 'url=dostavka(Page)';
			DeletCach($control['home'],$p);
		}
		exit();//Завершаем работу скрипта
	}
	else
	{
		$insert_id = $Object->Insert($arr,$name.'_controller, insert',$type);   //Запись новой строки в базу
		header("Location: ".$refer);                        //Выход к списку страниц
		if($sets['cach']==1)
		{
			include_once "models/admin/Del_Cach_model.php";//Подключение модели для очистки кэш файлов
			$p = array(); $p[] = 'url=dostavka(Page)';
			DeletCach($control['home'],$p);
		}
		exit();//Завершаем работу скрипта
	}
}

if($id>0)
{
	$data = $Object->Get_Object($id,$name.'_controller, data',$type);
}

$html = includes('views/admin/themes/default/content_tpl/Delivery_Object_content.php', array('data' => $data));