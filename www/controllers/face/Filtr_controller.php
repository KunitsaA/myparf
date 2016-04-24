<?

$file = file_get_contents('control.txt'); $control = unserialize($file);//получаем основные настройки

require_once $control['home'].'models/face/bd.php';//подключение к БД
require_once $control['home'].'models/face/Base_model.php';//подключение к базовой модели 
require_once $control['home'].'classes/Page_Class.php';//подключение файла с классом

$error_msg = 'Filtr_controller';//имя ошибки для запроса товаров
if(!$Page) $Page = new Page();//Подключение класса

if($_POST)
{
	$arr = $Page->Handle_Data($_POST['data']);//Обрабатываем переменные массив POST для использования в mysql запросе и конвертируем в массив $arr
	
	if($arr['min']<=$arr['min_val'] or $arr['max']>=$arr['max_val']) { unset($arr['min'],$arr['min_val'],$arr['max'],$arr['max_val']); }//Если занчения цены по умолчанию или не соответствуют, то удаляем их
	
	$quantity = 24;//количество выводимых товаров
	$where = '';//дополнительные условия запроса
	
	if(!$arr['sort']) { $sort = "t1.name"; }//сортировка по умолчанию
	else{//сортировка по условию
	  switch($arr['sort']):
		  case 1:  $sort = "t1.name"; break;
		  case 2:  $sort = "t1.name DESC"; break;
		  case 3:  $sort = "IF(t1.s_cena<>0,t1.s_cena,t1.cena)"; break;
		  case 4:  $sort = "IF(t1.s_cena<>0,t1.s_cena,t1.cena) DESC"; break;
	  endswitch;
	}
	
	if($arr['brand']) { $where .= " and t1.brand='".$arr['brand']."'"; }//если есть GET переменная brand, то устанавливаем условие   
	if($arr['type']) { $where .= " and t1.type IN (".$arr['type'].")"; }//если есть GET переменная type, то устанавливаем условие
	if($arr['min'] && $arr['max']) { $where .= ' and IF(t1.s_cena<>0,t1.s_cena,t1.cena) BETWEEN '.$arr['min'].' AND '.$arr['max'].''; }//если есть GET переменные min и max, то устанавливаем условие
	
	$objects = $Page->Get_Array($error_msg.' objects','Product t1 LEFT JOIN Brands t2 ON t1.brand=t2.id LEFT JOIN Product_Cat t3 ON t1.cat=t3.id LEFT JOIN Product_Type t4 ON t1.type=t4.id','t1.*,t2.name b_name,t3.id c_id,t3.url c_url,t4.name t_name'," WHERE t1.cat = '".$arr['cat']."' and t1.status='1'".$where," ORDER BY ".$sort." LIMIT ".$quantity." OFFSET ".$arr['c_obj']."");//Товары
	
	$c_obj = count($objects);
	for($e=0; $e<$c_obj; $e++)//добавление в массив модифицированного наименования товара
		{
			 $objects[$e]['name'] = htmlspecialchars($objects[$e]['name'],ENT_QUOTES);
			 $objects[$e]['m_name'] = preg_replace(array('/туалетная вода/iu','/парфюмерная вода/iu'), array('edt','edp'), $objects[$e]['name']);
			 //$objects[$e]['m_name'] = preg_replace('/\((.+)\)/i', '<span>($1)</span>', $objects[$e]['m_name']);
		}
	
}
echo json_encode($objects, JSON_HEX_TAG);