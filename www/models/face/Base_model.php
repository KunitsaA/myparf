<?

/*=================================================================
          Функция для извлечения массива строк из таблицы
=================================================================*/
//$p -Что извлекаем... $p2 - таблица +/- условия извлечения...
function array_get($p,$p2,$p3='function array_get') 
{
	$query = "SELECT ".$p." FROM ".$p2;
	$res = mysql_query($query);
	if(!$res) { echo $p3.'<br />'.$query.'<br/>'; die(mysql_error()); }
	
	$return = array();
	
	while($row = mysql_fetch_assoc($res))
	{
		$return[] = $row;
	}
	
	mysql_free_result($res);
	
	return $return;
}

/*=================================================================
          Функция для извлечения строки из таблицы
=================================================================*/
//$p -Что извлекаем... $p2 - таблица +/- условия извлечения...
function string_get($p,$p2,$p3='function string_get')
{
	$query = "SELECT ".$p." FROM ".$p2;
	$res = mysql_query($query);
	if(!$res){ echo $p3.'<br />'.$query.'<br/>'; die(mysql_error()); }
	
	$row = mysql_fetch_assoc($res);
	
	mysql_free_result($res);

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
	$del = implode(",",$p2);
	                            
	$res = mysql_query("DELETE FROM ".$p." WHERE id IN (".$del.")");
	if(!$res) { echo $p3.'<br />'; die(mysql_error()); }
								
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
	
	mysql_free_result($res);
	
	$return = array_filter($return);//Чистим пустые элементы массива
    $return = array_reverse($return);//Переворачиваем массив

	return $return;
}

/*=====================================================================
Счетчик просмотров статьи
=====================================================================*/
function counter_views($id)
{
	$return = update('articles',"views = views+1 WHERE id=".$id."");
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
          Запись массива в файл
================================================================*/

function array_json2file($arr,$filename)
{
	$str_value = json_encode($arr);
    
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
          Запись массива в файл в сжатом виде
================================================================*/

function array2filegz($arr,$filename)
{
	$str_value = serialize($arr);
    
	$gz = gzopen($filename,'w9');
	gzwrite($gz, $str_value);
	gzclose($gz);
}

/*================================================================
    Выборка данных из файла gz (Дейтствие обратное предыдущему)
================================================================*/

function array_from_filegz($filename)
{
    $gz = gzopen($filename,'r');
	$file = gzread($gz,1000000);
	gzclose($gz);
	
    $value = unserialize($file);
    return $value;
}

/*================================================================
    Проверка на существование имени в таблице
================================================================*/

function heck_name($name,$tab,$p3)
{
    $res = mysql_query("SELECT id FROM ".$tab." WHERE name='".$name."'");
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
    Вставляем товары заказа
================================================================*/

function Insert_Order_Dets($value)
{
	$res = mysql_query("INSERT INTO order_det (order_id, product_id, cena, cont) VALUES ".$value);
	if(!$res) die(mysql_error());
	
	return true;
}

/*================================================================

================================================================*/

function control_array()
{
	$file = file_get_contents('control.txt');
    $value = unserialize($file);
    return $value;
}
