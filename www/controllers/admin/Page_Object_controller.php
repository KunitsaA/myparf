<?

if($_POST){
	
	$arr = $Object->Handle_Data($_POST);                     //Обработка данных перед использованием
	
	if($_POST['id'])
	{
		$Object->Update($arr,$name.'_controller, update');   //Редактирование строки
		header("Location: admin.php?c=Page_List");           //Выход к списку страниц
		
		if($sets['cach']==1)
		{
			include_once 'models/admin/Del_Cach_model.php';//Подключение модели для очистки кэш файлов
			$p = array(); $p[] = '(Header)'; $p[] = 'Main'; $p[] = '.c=Page';
		    DeletCach($control['home'],$p);
		}
		
		exit();//Завершаем работу скрипта
	}
	else
	{
		$arr['url'] = translit($arr['name']);                //Создаем значение url с помощью транслита параметра name
		if($arr['title']=='') $arr['title'] = $arr['name'];  //Если значение title пустое, то присваиваем ему значение name
		$Object->Insert($arr,$name.'_controller, insert');   //Запись новой строки в базу
		header("Location: admin.php?c=Page_List");           //Выход к списку страниц
		
		if($sets['cach']==1)
		{
			include_once 'models/admin/Del_Cach_model.php';//Подключение модели для очистки кэш файлов
			$p = array(); $p[] = '(Header)'; $p[] = 'Main'; $p[] = '.c=Page';
		    DeletCach($control['home'],$p);
		}
		exit();//Завершаем работу скрипта
	}
}

if($id>0) $data = $Object->Get_Object($id,$name.'_controller, data');

$html = includes('views/admin/themes/default/content_tpl/'.$name.'_content.php', array('data' => $data));