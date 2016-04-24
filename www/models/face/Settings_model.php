<?
function get_settings($control){
	require_once $control['home'].'models/face/Base_model.php'; //Подключаем общую модель
    $sets_file = $control['home'].'models/face/settings.txt';//Путь к файлу с настройками

	if(file_exists($sets_file)) //Если файл с настройками существует...
	{
		$sets = array_from_file($sets_file);//Берем массив настроек из файла
		if(count($sets)==0)//Если массив настроек пуст, то получаем настройки из бд
		{
			include_once $control['home'].'models/face/bd.php';//Соединение с БД
			$sets = string_get('*',"settings WHERE id='1'",'Base_controller.php, sets');//Получение данных из таблицы настройки
			array2file($sets,$sets_file);//Записываем настройки в файл
		}
	}
	else//Иначе обращаемся к бд
	{
		include_once $control['home'].'models/face/bd.php';//Соединение с БД
		$sets = string_get('*',"settings WHERE id='1'",'Base_controller.php, sets');//Получение данных из таблицы настройки
		array2file($sets,$sets_file);//Записываем настройки в файл
	}

return $sets;

}