<?

$file = file_get_contents('control.txt'); $control = unserialize($file);//получаем основные настройки

require_once $control['home'].'models/face/bd.php';//подключение к БД
require_once $control['home'].'models/face/Base_model.php';//подключение к базовой модели 
require_once $control['home'].'classes/Page_Class.php';//подключение файла с классом

$error_msg = 'Price_controller';//имя ошибки для запроса товаров
if(!$Page) $Page = new Page();//Подключение класса

if($_POST)
{
	$arr = $Page->Handle_Data($_POST['data']);//Обрабатываем переменные массив POST для использования в mysql запросе и конвертируем в массив $arr
	
	$where = '';//дополнительные условия запроса
	
	if($arr['brand']!='') { $where .= " and brand='".$arr['brand']."'"; }//если есть GET переменная brand, то устанавливаем условие
	
	$prices = $Page->Get_Array($error_msg.' prices','Product','id,type,s_cena,cena'," WHERE cat = '".$arr['cat']."' and status='1' and krym='1'".$where," ");//Товары
}
echo json_encode($prices, JSON_HEX_TAG);