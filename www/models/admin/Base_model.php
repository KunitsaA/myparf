<?

/*=================================================================
          Функция для извлечения массива строк из таблицы
=================================================================*/
//$p -Что извлекаем... $p2 - таблица +/- условия извлечения...
function array_get($p,$p2,$p3='function array_get') 
{
	$res = mysql_query("SELECT ".$p." FROM ".$p2."");
	if(!$res) { echo $p3.'<br />'; die(mysql_error()); }
	
	$return = array();
	
	while($row = mysql_fetch_assoc($res))
	{
		$return[] = $row;
	}
	
	return $return;
}

/*=================================================================
          Функция для извлечения строки из таблицы
=================================================================*/
//$p -Что извлекаем... $p2 - таблица +/- условия извлечения...
function string_get($p,$p2,$p3='function string_get')
{
	$res = mysql_query("SELECT ".$p." FROM ".$p2."");
	if(!$res) { echo $p3.'<br />'; die(mysql_error()); }
	
	$row = mysql_fetch_assoc($res);

	return $row;
}

/*=================================================================
          Функция для UPDATE
=================================================================*/
//$p - таблица $p2 - Что обновляем... Пример `столбец`='".$пременная."' +/- условия обновления...
function update($p,$p2,$p3='function update')
{
	$res = mysql_query("UPDATE ".$p." SET ".$p2."");
	if(!$res) { echo $p3.'<br />'; die(mysql_error()); }
	return $res;
}

/*=================================================================
          Функция для INSERT
=================================================================*/
//$p - таблица $p2 - Что вставляем... Пример (`столбец`, `столбец`) VALUES ('".$переменная."', '".$переменная."')
function insert($p,$p2,$p3='function insert')
{
	$res = mysql_query("INSERT INTO ".$p." ".$p2."");
	if(!$res) { echo $p3.'<br />'; die(mysql_error()); }
}

/*=================================================================
          Функция для DELETE
=================================================================*/

function delete($p,$p2,$p3='function delete')
{
	//if(is_array($p2)) $del = implode(",",$p2); else $del = $p2;
	                            
	$res = mysql_query("DELETE FROM ".$p." WHERE id IN (".$p2.")");
	if(!$res) { echo $p3.'<br />'; die(mysql_error()); }
	
	return $res; 
								
}

/*=================================================================
          Функция для DELETE для деталей заказа
=================================================================*/

function delete_dets($p,$p2='function delete')
{
	//if(is_array($p2)) $del = implode(",",$p2); else $del = $p2;
	                            
	$res = mysql_query("DELETE FROM Order_Det WHERE order_id IN (".$p.")");
	if(!$res) { echo $p2.'<br />'; die(mysql_error()); }
	
	return $res; 
								
}

/*=====================================================================
Кэширование в файл ($infile) содержимого ($html)
=====================================================================*/
function cach_file($infile,$html)
{
	$fp = fopen($infile, "a"); // Открываем файл в режиме записи
    $test = fwrite($fp, $html); // Запись в файл
    fclose($fp); //Закрытие файла
}
/*========================================================================
Транслитерация для url
=========================================================================*/
function translit($text)
{
    // Русский алфавит
    $rus = array(
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й',
        'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф',
        'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
        'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й',
        'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф',
        'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', ' ', '.', ',', '-', ':', ';', '!', '(', ')', '[', ']', '"', '%', '`', "'" 
    );
    
    // Английская транслитерация
    $translit = array(
        'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'i',
        'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f',
        'h', 'c', 'ch', 'sh', 'sh', '', 'y', '', 'e', 'yu', 'ya',
        'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'i',
        'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f',
        'h', 'c', 'ch', 'sh', 'sh', '', 'y', '', 'e', 'yu', 'ya', '-', '', '', '-', '', '', '', '', '', '', '', '', '', '', ''
    );
    
    return str_replace($rus, $translit, $text);
}
/*=====================================================================
Навигационная функция
=====================================================================*/
function navigator($p,$type)
{
	$res = mysql_query("SELECT parent,url,name FROM ".$type."_Cat WHERE id='".$p."'");
	if(!$res) die(mysql_error());
	
	$return = array();
	
	$row = mysql_fetch_array($res);
	
	$return[] = array('url' => $row['url'],'name' => $row['name'],);
	
	if($row['parent']!=0) 
	{
		$ret = navigator($row['parent'],$type);
		$c_ret = count($ret);
	    for ($i=0; $i<$c_ret; $i++)
		 {
			 $return[] = $ret[$i];
		 } 
	}
	
	$return = array_filter($return);//Чистим пустые элементы массива
    $return = array_reverse($return);//Переворачиваем массив

	return $return;
}

/*=====================================================================
Счетчик просмотров статьи
=====================================================================*/
function counter_views($id)
{
	$return = update('Articles',"views = views+1 WHERE id=".$id."");
    return $return;
}
/*================================================================
          Запись массива в файл
================================================================*/

function array2file($arr,$filename)
{
	$str_value = serialize($arr);
    
    $f = fopen($filename, 'w');
    fwrite($f, $str_value);
    fclose($f);
}

/*================================================================
    Выборка массива из файла (Дейтствие обратное предыдущему)
================================================================*/

function array_from_file($filename)
{
    $file = file_get_contents($filename);
    $value = unserialize($file);
    return $value;
}

/*================================================================
    Проверка на существование имени в таблице // ТРЕБУЕТ ПРОВЕРКИ НА ССЕРВЕРЕ
================================================================*/

function check_name($name,$tab,$p3)
{
	$url = translit($name);
    $res = mysql_query("SELECT id FROM ".$tab." WHERE name='".$name."' OR url='".$url."'");
	if(!$res) { echo $p3.'<br />'; die(mysql_error()); }
	
	$return_res = array();
	
	while($row = mysql_fetch_assoc($res))
	{
		$return_res[] = $row;
	}
	
	if(count($return_res)>0) $return = true; else $return = false;
	
	return $return;
}

/*================================================================
Построение меню Админ.Панели в зависимости от наличия таблиц
================================================================*/

function Check_Tables($db_name)
{
	$res = mysql_query("SHOW TABLES FROM ".$db_name);
	if(!$res) die(mysql_error());
	
	$return = array();	
	$return[0] = '<ul><li><a href="admin.php">Главная</a></li>';
	
	while($row = mysql_fetch_row($res))
	{		
		switch(ucfirst($row[0])){			
			case 'Orders':        $return[1] = '<li><a href="admin.php?c=Orders_List">Заказы</a></li>'; break;
			case 'Page':          $return[2] = '<li><a href="admin.php?c=Page_List">Страницы</a></li>'; break;
			case 'Product':       $return[3] = '<li><a href="admin.php?c=Product_List">Каталог</a></li>'; break;
			case 'Char_groups':   $return[4] = '<li><a href="admin.php?c=Chars_List">Характеристики</a></li>'; break;
			case 'Brands':        $return[5] = '<li><a href="admin.php?c=Brands_List">Бренды</a></li>'; break;
			case 'Delivery':      $return[6] = '<li><a href="admin.php?c=Delivery_List">Доставка</a></li>'; break;
			case 'Reviews':       $return[7] = '<li><a href="admin.php?c=Reviews_List">Отзывы</a></li>'; break;
			case 'Portfolio':     $return[8] = '<li><a href="admin.php?c=Portfolio_List">Портфолио</a></li>'; break;
			case 'Articles':      $return[9] = '<li><a href="admin.php?c=Articles_List">Статьи</a></li>'; break;
			case 'Settings':      $return[10] = '<li><a href="admin.php?c=Settings">Настройки</a></li>'; break;			
		}
	}
	
	$return[11] = '<li><a href="Out.php">Выход</a></li>';
    $return[12] = '</ul>';
	
	ksort($return);	
	return $return;
}
/*================================================================

================================================================*/

function control_array()
{
	$file = file_get_contents('control.txt');
    $value = unserialize($file);
    return $value;
}