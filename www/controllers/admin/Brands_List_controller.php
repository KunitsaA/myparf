<?
$error_msg = $name.'_controller';

if($_POST)
{
	$arr = $Object->Handle_Data($_POST);                    //Обработка данных перед использованием
	$Object->Delete($arr['id'],$name.'_controller, function DELETE','Brands');
	header("Location: ".$_SERVER['HTTP_REFERER']);          //Выход к исходной странице
	if($sets['cach']==1)
	{
		include_once "models/admin/Del_Cach_model.php";//Подключение модели для очистки кэш файлов
		$p = array(); $p[] = '.c=Product_Cat'; $p[] = '.c=Product_Object'; $p[] = 'Main(Page)';
		DeletCach($control['home'],$p);
	}
	exit();//Завершаем работу скрипта
}

$data = $Object->Get_Array($error_msg.', data', 'Brands', '*', '', ' ORDER BY name');

$html = includes('views/admin/themes/default/content_tpl/'.$name.'_content.php', array('data' => $data));