<?

function get_tpl($sets,$name_array,$gets,$id,$find,$c,$control,$url)
{
    $type = $find[0]; $ffend = $find[1].'_controller.php';//Преобразование $_GET контроллера в "направление" и определяющий файл контроллера (общий файл)
	
	$controller_PATH = $control['home'].'controllers/face/'; 
	
	$return = array();
	
	//error_reporting(E_ALL);
	
	if($sets['cach']==1)//$cach
    {
		if($gets=='') { $gets = 'Main'; }
		$cach_PATH = 'cach/'.$gets;
	    	
		if(!file_exists($cach_PATH.'('.$c.').html') or !file_exists($cach_PATH.'(Head).html'))
		{
			include_once $control['home'].'models/face/bd.php';//Соединение с БД
			require_once $control['home'].'models/face/Base_model.php'; //Подключаем общую модель
			$c = mysql_real_escape_string($c); $id = intval($id);
			
			$tab = ($find && $find[1] == 'Object') ? $type : $c;
			$getData = string_get('id', $tab." WHERE url='".mysql_real_escape_string($_GET['url'])."'", 'Base_controller, function get_tpl('.$name.'), getData');
			$id = $getData['id'];
			
			
			include_once $control['home'].'classes/Page_Class.php'; $Page = new Page();				
			$data = $Page->Get_Object($id, $c.'_controller, function get_tpl, data',$tab);//Данные о странице
			
		}
		
		foreach($name_array as $name)
		{
			if($name=='Header' or $name=='Footer' or $name=='Catalog_Menu') { $cach_PATH = 'cach/'; } else { $cach_PATH = 'cach/'.$gets; }
			
			$cach_f = $cach_PATH.'('.$name.').html';//Путь к файлу кэша
			
			if($url=='search' or $url=='cart' or $url=='order' or $_GET['min'] or $_POST)
			{
				include_once($controller_PATH.$name.'_controller.php');//Подключаем "КОНТЕНТ" контроллер
				$return[] = $html;
			}
			else
			{
				if (!file_exists($cach_f))//Если кэш файла нет, тогда создаем его...
				{					
					if (file_exists($controller_PATH.$name.'_controller.php')) include_once($controller_PATH.$name.'_controller.php');//Подключаем "КОНТЕНТ" контроллер
					else
					{
						$dir = opendir($controller_PATH); 
						while(($file = readdir($dir)) !== false)//Перебираем файлы в папке
						{	
							if(strpos($file,$ffend) !== false) include_once($controller_PATH.$file); //Ищем нужный контроллер (_Сatalog,_Cat и т.д.) и подключаем
						}
						closedir($dir);//Закрываем папку
					}
					cach_file($cach_f,$html);//Кэширование 
					unset($html);
				}
				$return[] = file_get_contents($cach_f);//Получаем содержимое из кэша
			}
			
		}
	}
    else
    {
		include_once $control['home'].'models/face/bd.php';//Соединение с БД
		require_once $control['home'].'models/face/Base_model.php'; //Подключаем общую модель
		$c = mysql_real_escape_string($c); $id = intval($id);
		
		$tab = ($find && $find[1] == 'Object') ? $type : $c;
		
		if(!$id)
		{
			$data = string_get('*', $tab." WHERE url='".mysql_real_escape_string($_GET['url'])."'", 'Base_controller, function get_tpl('.$name.'), getData');
		    $id = $getData['id'];
		}
		else
		{
			include_once $control['home'].'classes/Page_Class.php'; $Page = new Page();
			
			if($c=='Product_Object')
			    $data = string_get('t1.*, t2.url c_url, t2.name c_name, t3.name b_name, t4.name t_name', $tab." t1 LEFT JOIN Product_Cat t2 ON t1.cat=t2.id LEFT JOIN Brands t3 ON t1.brand=t3.id LEFT JOIN Product_Type t4 ON t1.type=t4.id WHERE t1.id='".$id."'", $c.'_controller, function get_tpl, data');//Данные о странице
			else
				$data = $Page->Get_Object($id, $c.'_controller, function get_tpl, data',$tab);//Данные о странице
			
			if(isset($_GET['brand'])) $data_b = $Page->Get_Object(intval($_GET['brand']), $error_msg.' data_b','Brands');//Данные о странице
			
		}
		
		
		foreach($name_array as $name)
		{
			if (file_exists($controller_PATH.$name.'_controller.php')) include_once($controller_PATH.$name.'_controller.php'); //Подключаем "КОНТЕНТ" контроллер
			else
			{
				$dir = opendir($controller_PATH);
				while(($file = readdir($dir)) !== false)//Перебираем файлы в папке
				{
					if(strpos($file,$ffend) !== false) include_once($controller_PATH.$file); //Ищем нужный контроллер (_Сatalog,_Cat и т.д.) и подключаем
				}
				closedir($dir);//Закрываем папку
			}
	        $return[] = $html;//Получаем содержимое из кэша
			unset($html);
		}
    }
	
	return $return;
}