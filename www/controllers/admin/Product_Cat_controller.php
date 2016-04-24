<?

if($_POST)
{
	$arr = $Object->Handle_Data($_POST);
	$refer = $arr['refer']; $char_id = $arr['char_id']; unset($arr['refer'],$arr['char_id']);
	
	if($_POST['id'])
	{
		$Object->Update($arr,$name.'_controller, update',$name);   //Редактирование строки
		
		if(count($char_id)>0) $Object->Add_Char($arr['id'],$char_id);
		
		header("Location: ".$refer);           //Выход к списку страниц
		
		if($sets['cach']==1)
		{
			include_once 'models/admin/Del_Cach_model.php';//Подключение модели для очистки кэш файлов
			AllDeletCach($control['home']);
		}
		exit();//Завершаем работу скрипта
	}
	else
	{
		$arr['url'] = translit($arr['name']);                             //Создаем значение url с помощью транслита параметра name
		if($arr['title']=='') $arr['title'] = $arr['name'];               //Если значение title пустое, то присваиваем ему значение name
		$insert_id = $Object->Insert($arr,$name.'_controller, insert',$name);   //Запись новой строки в базу
		if(count($char_id)>0) $Object->Add_Char($insert_id,$char_id);
		include_once 'controllers/admin/add.php';
		header("Location: ".$refer);                        //Выход к списку страниц
		
		if($sets['cach']==1)
		{
			include_once 'models/admin/Del_Cach_model.php';//Подключение модели для очистки кэш файлов
			AllDeletCach($control['home']);
		}
		exit();//Завершаем работу скрипта
	}
}
$chars = $Object->Get_Array($error_msg.' chars','Char_Groups','*');//Все характеристики

if($id)
{
	$data = $Object->Get_Object($id,$name.'_controller, data',$name);//Данные об объекте
	
	$th_ch = array();//Характеристики для этой категории
	
	$chars_count = count($chars); for ($i=0; $i<$chars_count; $i++) { $chars[$i]['cat'] = explode(',',$chars[$i]['cat']); if(in_array($id, $chars[$i]['cat'])) { $th_ch[] = $chars[$i]; } }
}


//Сборка всех данных в шаблон контент
$html = includes('views/admin/themes/default/content_tpl/'.$name.'_content.php', array('data' => $data, 'chars' => $chars, 'th_ch' => $th_ch));