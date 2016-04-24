<?
if($_POST)
{
	$arr = $Object->Handle_Data($_POST);
	
	$refer = $arr['refer']; $index = $arr['index']; unset($arr['refer'],$arr['index']);

	if($_POST['id'])
	{
		$Object->Update($arr,$name.'_controller, update',$type);   //Редактирование строки
		include_once 'controllers/admin/edit.php';
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
		$insert_id = $Object->Insert($arr,$name.'_controller, insert',$type);   //Запись новой строки в базу
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

$check = $Object->Check_Columns($name.'_controller, check',$type);

$A_chars = $Object->Get_Array($error_msg.' chars','Char_Groups','*');
$chars_c = count($A_chars); $chars = array(); 

if($id>0)
{
	$data = $Object->Get_Object($id,$name.'_controller, data',$type);
			
	for ($i=0; $i<$chars_c; $i++)
	{
		$A_chars[$i]['cat'] = explode(',',$A_chars[$i]['cat']); if(in_array($data['cat'], $A_chars[$i]['cat'])) { $chars[] = $A_chars[$i]; }
	}
}
else
{
	for ($i=0; $i<$chars_c; $i++)
	{
		$A_chars[$i]['cat'] = explode(',',$A_chars[$i]['cat']); if(in_array($_GET['cat'], $A_chars[$i]['cat'])) { $chars[] = $A_chars[$i]; }
	}
}
unset($A_chars);

$brands = $Object->Get_Array('Product_Object_controller brands','Brands','*','',' ORDER BY name');
$types = $Object->Get_Array('Product_Object_controller types','Product_Type','*','',' ORDER BY name');

$html = includes('views/admin/themes/default/content_tpl/'.$name.'_content.php', array('data' => $data, 'check' => $check, 'chars' => $chars, 'brands' => $brands, 'types' => $types));