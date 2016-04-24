<?

function get_tpl_admin($sets,$name_array,$gets,$id,$find,$c,$control)
{
    $type = $find[0]; $ffend = $find[1].'_controller.php';//Преобразование $_GET контроллера в "направление" и определяющий файл контроллера (общий файл)
	
	$controller_PATH = 'controllers/admin/'; 
	
	$return = array();
	
	//error_reporting(E_ALL);
	include_once 'models/admin/bd.php';//Соединение с БД
	require_once 'models/admin/Base_model.php';
	
	if (file_exists('classes/'.$type.'_Class.php'))
	{
		include_once ('classes/'.$type.'_Class.php'); 
		$Object = new $type;			
	}
	else
	{
		include_once ('classes/Page_Class.php'); $Object = new Page();
	}
	
	foreach($name_array as $name)
	{
		if (file_exists($controller_PATH.$name.'_controller.php')) include_once($controller_PATH.$name.'_controller.php');//Подключаем "КОНТЕНТ" контроллер
		else
		{
			$dir = opendir($controller_PATH);
			while(($file = readdir($dir)) !== false)//Перебираем файлы в папке
			{
				if(strpos($file,$ffend) !== false && strpos($file,'Page') === false) include_once($controller_PATH.$file); //Ищем нужный контроллер (_Сatalog,_Cat и т.д.) и подключаем
			}
			closedir($dir);//Закрываем папку
		}
		$return[] = $html;//Получаем содержимое из кэша
		unset($html);
	}
    
	
	return $return;
}