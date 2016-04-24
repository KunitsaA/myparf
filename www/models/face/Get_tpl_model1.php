<?
/*
***** $sets - массив настройки
***** $name - $c или Название контроллера
***** $gets - массив $_GET в строку
***** $id - id текущего элемента из БД по умолчанию (если значение пустое, то определяется внутри функции)
***** $find - массив из $c (контроллера)
*/
function get_tpl($sets,$name,$gets,$id,$find,$c)
{
	/*Преобразование $_GET контроллера в "направление" и определяющий файл контроллера (общий файл) */ 
    $type = $find[0]; $ffend = $find[1].'_controller.php';
    /********************************************************/
	
	if($sets['cach']==1)//$cach
    {
		$cach_f = 'cach/'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'.html';//Путь к файлу кэша
	    
        if (!file_exists($cach_f))//Если кэш файла нет, тогда создаем его...
	    {
			include_once ('models/face/Base_model.php'); //Подключаем общую модель
			
			if($id == ''){//Если нет значения $id, то получаем по $_GET['url']
				$tab = ($find && $find[1] == 'Object') ? $find[0] : $c;
				$getData = string_get('id', $tab." WHERE url='".mysql_real_escape_string($_GET['url'])."'", 'Base_controller, function get_tpl('.$name.'), getData'); $id = $getData['id'];
			}
			
			if (file_exists('controllers/'.$name.'_controller.php')) { include_once('controllers/'.$name.'_controller.php'); }//Подключаем "КОНТЕНТ" контроллер
            else
            {
	            $dir = opendir('controllers/'); while(($file = readdir($dir)) !== false)//Перебираем файлы в папке
													{
														//Ищем нужный контроллер (_Сatalog,_Cat и т.д.) и подключаем	
														if(strpos($file,$ffend) !== false) { include_once('controllers/'.$file); }
													}
	            closedir($dir);//Закрываем папку
            }
		    cach_file($cach_f,$html);//Кэширование 
        }
    
	    $return = file_get_contents($cach_f);//Получаем содержимое из кэша
	}
    else
    {
		include_once ('models/face/Base_model.php'); //Подключаем общую модель
			
		if($id == '' && $id != 0){//Если нет значения $id, то получаем по $_GET['url']
			$tab = ($find && $find[1] == 'Object') ? $find[0] : $c;
			$getData = string_get('id', $tab." WHERE url='".mysql_real_escape_string($_GET['url'])."'", 'Base_controller, function get_tpl('.$name.'), getData'); $id = $getData['id'];
		}
		
	    if (file_exists('controllers/face/'.$name.'_controller.php')) { include_once('controllers/face/'.$name.'_controller.php'); }//Подключаем "КОНТЕНТ" контроллер
        else
        {
	        $dir = opendir('controllers'); while(($file = readdir($dir)) !== false)//Перебираем файлы в папке
												{
													//Ищем нужный контроллер (_Сatalog,_Cat и т.д.) и подключаем
													if(strpos($file,$ffend) !== false) { include_once('controllers/face/'.$file); } 
												}
	        closedir($dir);//Закрываем папку
        }
	    $return = $html;//Получаем содержимое из кэша
    }
	
	return $return;
}
