<?

class Page{
  
  //Выборка данных из таблицы "Страницы"
  //$error_msg - сообщение о координатах ошибки
  public function Get_Array($error_msg,$tab='Page',$columns='id,url,name,status',$where='',$orderby=' ORDER BY id')
  {
	  $return = array_get($columns, $tab.$where.$orderby, $error_msg);
	  
	  return $return;
	  
	  $return = null;
  }
  
  //Выборка данных из таблицы "Страницы" строки с id = $id
  //$error_msg - сообщение о координатах ошибки
  public function Get_Object($id,$error_msg,$tab='Page',$columns='*',$where='')
  {
	  $return = string_get($columns, $tab." WHERE id='".$id."'", $error_msg);
	  
	  return $return;
	  
	  $return = null;
  }
  
  //Вставки строки в таблицу "Страницы"
  //$data - массив переменных
  //$error_msg - сообщение о координатах ошибки
  public function Insert($data,$error_msg,$tab='Page')
  {
	  $str = $this->Bild_Insert_Query($data);
	  
	  $return = insert($tab,"(".$str[0].") VALUES (".$str[1].")",$error_msg);
	  
	  $return = mysql_insert_id(); return $return;
	  
	  $return = null;
  }
  //Редактирование таблицы "Страницы". Обновление строки с id = $id
  //$data - массив переменных
  //$error_msg - сообщение о координатах ошибки
  public function Update($data,$error_msg,$tab='Page')
  {
	  $str = $this->Bild_Update_Query($data);
	  
	  $return = update($tab,$str,$error_msg);
	  
	  return $return;
	  
	  $return = null;
  }
  
  //Удаление строк(и) из таблицы "Страницы" с id =$id
  //$id - id строки или массив с id строк
  //$error_msg - сообщение о координатах ошибки
  public function Delete($id,$error_msg,$tab='Page')
  {
	  $return = delete($tab,$id,$error_msg);
	  
	  return $return;
	  
	  $return = null;
  }
  
  //Выборка существующих полей из таблицы
  //$error_msg - сообщение о координатах ошибки, $tab - имя таблицы
  public function Check_Columns($error_msg,$tab='Page')
  {
	  $res = mysql_query("SHOW COLUMNS FROM ".$tab);
	  if(!$res) { echo $error_msg.'<br />'; die(mysql_error()); }
	  
	  $return = array();
	
	  while($row = mysql_fetch_assoc($res))
	  {
		  $return[$row['Field']] = $row['Field'];
	  }
	  
	  mysql_free_result($res);
	  
	  return $return;
  }
  
  //Обработка данных перед использованием. Например данные из массива $_POST
  //$data - массив для обработки
  public function Handle_Data($data)
  {
	  $arr = array();
	
	  foreach ($data as $key => $val)//Преобразовываем каждый элемент в вид ( Ключ : Значение )
	  {
		  if(is_array($val))//Если элемент является массивом, то опять преобразовываем в вид ( Ключ : Значение )
		  {
			  if(preg_match("/^im(.+)$/",$key))
			  {
				  $c_val = count($val);
				  for($i=0; $i<$c_val; $i++) { $a = $i+1; $arr[$key.$a] = mysql_real_escape_string($val[$i]); }
			  }
			  else
			  {
				  $arr[$key] = array();
				  foreach ($val as $k => $v)//Обрабатываем каждое значение
				  {
					  if (is_numeric($v)) { array_push($arr[$key],intval($v)); }
					  else { array_push($arr[$key],mysql_real_escape_string(trim($v))); } 
				  }
				  $arr[$key] = implode(',',$arr[$key]);//Все значения записываем в строку через запятую
			  }
		  }
		  else//Обрабатываем каждое значение
		  {
			  $arr[$key] = (is_numeric($val)) ? intval($val) : mysql_real_escape_string(trim($val));
		  }
	  }
	  
	  return $arr;
  }
  
  //Динамическое построение запроса INSERT в зависимости от полученных данных
  //$data - массив с данными (поле : значение)
  private function Bild_Insert_Query($data)
  {
	  $count_data = count($data);//Узнаем количество элементов в массиве
	  $str = array();//Создаем массив строк для вставки в запрос типа: " INSERT INTO table_name ($str[0]) VALUES ($str[1]) "
	  
	  $i = '0';
	  foreach($data as $k=>$v)
	  {	
		  $str[0] .= ($i==($count_data-1)) ? $k : $k.',';//Строка с полями
		  $str[1] .= ($i==($count_data-1)) ? "'".$v."'" : "'".$v."',";//Строка со значениями, которые вставляем
		  $i++;
	  }
	  return $str;
  }
  
  //Динамическое построение запроса UPDATE в зависимости от полученных данных
  //$data - массив с данными (поле : значение)
  private function Bild_Update_Query($data)
  {
	  $id = $data['id'];//Назначаем переменную со значением поля id
	  unset($data['id']);//Очищаем массив от поля id (чтобы оставить только обновляемые поля)
	  $count_data = count($data);//Узнаем количество элементов в массиве
	  
	  $i = '0'; $str = '';
	  foreach($data as $k=>$v)
	  {	
		  $str .= ($i==($count_data-1)) ? "".$k."='".$v."' WHERE id='".$id."'" : "".$k."='".$v."',";//Строим строку вида: " param = '$param', param2 = '$param2' WHERE id = '$id' "
		  $i++;
	  }
	  return $str;
  }
  
  public function Object_Settings($home,$type){
	
	  $sets_file = $home.'control/'.$type.'_Settings.txt';//Путь к файлу с настройками
  
	  if(file_exists($sets_file)) //Если файл с настройками существует...
	  {
		  include_once ('models/admin/Base_model.php'); //Подключаем общую модель
		  $sets = array_from_file($sets_file);//Берем массив настроек из файла
		  if(count($sets)==0)//Если массив настроек пуст, то получаем настройки из бд
		  {
			  $sets = string_get('*',$type."_Settings WHERE id='1'",'function Object_Settings('.$type.')');//Получение данных из таблицы настройки
			  array2file($sets,$sets_file);//Записываем настройки в файл
		  }
	  }
	  else//Иначе обращаемся к бд
	  {
		  include_once ('models/admin/Base_model.php'); //Подключаем общую модель
		  $sets = string_get('*',$type."_Settings WHERE id='1'",'function Object_Settings('.$type.')');//Получение данных из таблицы настройки
		  array2file($sets,$sets_file);//Записываем настройки в файл
	  }
  
      return $sets;
  
  }
  
  //Получение полей с изображениями таблице объекта
  private function Get_Images_Columns($error_msg,$db_name,$tab='Product')
  {
	  $res = mysql_query("SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$db_name."' AND TABLE_NAME = '".$tab."' AND COLUMN_NAME LIKE 'im%'");
	  
	  if(!$res) { echo $error_msg.'<br />'; die(mysql_error()); }
	  
	  $return = 'DISTINCT '; $count = mysql_num_rows($res); $i=0;
	
	  while($row = mysql_fetch_assoc($res))
	  {
		  $return .= ($i==($count-1)) ? $row['COLUMN_NAME'] : $row['COLUMN_NAME'].','; $i++;
	  }
	  
	  mysql_free_result($res);
	  
	  return $return;
  }
    
  //Удаление изображений для объектов, которые удаляются из БД
  public function Delete_Images($home_dir,$db_name,$tab,$id)
  {
	  $file = $home_dir.'control/'.$tab.'_Images.txt';//Путь к файлу с полями изображений

	  if(file_exists($file)) //Если файл существует...
	  {
		  include_once ($home_dir.'models/admin/Base_model.php'); //Подключаем общую модель
		  $Images_Columns = array_from_file($file);//Берем массив полей из файла
		  if(count($Images_Columns)==0)//Если файл пуст, то получаем данные из бд
		  {
			  $Images_Columns = $this->Get_Images_Columns($error_msg,$db_name,$tab);
			  array2file($Images_Columns,$file);//Записываем данные в файл
		  }
	  }
	  else//Иначе обращаемся к бд
	  {
		  include_once ($home_dir.'models/admin/Base_model.php'); //Подключаем общую модель
		  $Images_Columns = $this->Get_Images_Columns($error_msg,$db_name,$tab);
		  array2file($Images_Columns,$file);//Записываем данные в файл
	  }
	  
	  $Images = $this->Get_Array($error_msg,$tab.' WHERE id IN ('.$id.')',$Images_Columns);
	  
	  foreach($Images as $key => $val)
	  {
		  foreach($val as $k => $v) { if(file_exists($home_dir.$v)) @unlink($home_dir.$v); }
	  }
  }
  
  //Получение характеристик для этой категории
  public function Get_Characteristics($error_msg,$cat,$where='')
  {  
	  $return = array_get('DISTINCT char1,char2,char3,char4,char5,char6,char7,char8,char9,char10', "Product WHERE cat='".$cat."' and status='1'".$where, $error_msg);
	  
	  $ret = array();
	  
	  foreach($return as $r){ for($i=1; $i<=10; $i++): $ret['char'.$i][] = $r['char'.$i]; endfor; }
	  
	  $count_r = count($ret); for($i=0; $i<$count_r; $i++){ $a = $i+1; $ret['char'.$a] = array_filter($ret['char'.$a]); $ret['char'.$a] = array_unique($ret['char'.$a]); sort($ret['char'.$a]); }
	  
	  $ret = array_filter($ret);
	  
	  return $ret;
  }
  
  //Обработка GET переменных для ФИЛЬТРА КАТАЛОГА и заготовка переменных WHERE
  public function Filtr_Catalog($data)
  {
	  $where = ''; $where2 = '';
	  
	  for($i=1; $i<=10; $i++)
	  {
		  if($data['char'.$i])
		  {
			  if(is_array($data['char'.$i]))//Если элемент является массивом, то опять преобразовываем в вид ( Ключ : Значение )
			  {
				  $arr = array();
				  foreach ($data['char'.$i] as $k => $v)//Обрабатываем каждое значение
				  {
					  if (is_numeric($v)) { array_push($arr,intval($v)); }
					  else { array_push($arr,mysql_real_escape_string(trim($v))); } 
				  }
				  $c_arr = count($arr); $in = '';
				  for($j=0; $j<$c_arr; $j++)
				  {
					  $in .= ($j == ($c_arr-1)) ? "'".$arr[$j]."'" : "'".$arr[$j]."',";
				  }
				  //$arr = implode(',',$arr);//Все значения записываем в строку через запятую
			  }
			  
			  $where .= " and char".$i." IN (".$in.")";
			  $where2 .= " and t1.char".$i." IN (".$in.")";
		  }
	  }
	  
	  $return = array();
	  
	  $return[] = $where; $return[] = $where2;
	  
	  return $return;
	  
  }
  
  //Выборка предыдущего и следующего объекта
  public function PrevNext($type,$id,$cat)
  {
	  
	  //Предыдущий и следующий объект, если всего записей 2
	  $data_p = array_get('t1.*,t2.name b_name,t3.id c_id,t3.url c_url,t4.name t_name',$type." t1 LEFT JOIN brands t2 ON t1.brand=t2.id LEFT JOIN Product_Cat t3 ON t1.cat=t3.id LEFT JOIN Product_Type t4 ON t1.type=t4.id WHERE t1.id < '".$id."' and t1.cat = '".$cat."' and t1.status='1' ORDER BY t1.id DESC LIMIT 3",$type.'_Object_controller, data_p');//Выборка предыдущей записи из БД, если предыдущей записи нет, то делаем выборку последней записи	
			 if(count($data_p)==0) $data_p = array_get('t1.*,t2.name b_name,t3.id c_id,t3.url c_url,t4.name t_name',$type." t1 LEFT JOIN brands t2 ON t1.brand=t2.id LEFT JOIN Product_Cat t3 ON t1.cat=t3.id LEFT JOIN Product_Type t4 ON t1.type=t4.id WHERE t1.id > '".$id."' and t1.cat = '".$cat."' and t1.status='1' ORDER BY t1.id DESC LIMIT 3",$type.'_Object_controller, data_p');
			 
	  $c_datap = count($data_p);
	  if($c_datap>0)
	  {
		  for($e=0; $e<$c_datap; $e++)//добавление в массив модифицированного наименования товара
		  {
			   $data_p[$e]['name'] = htmlspecialchars($data_p[$e]['name'],ENT_QUOTES);
			   $data_p[$e]['m_name'] = preg_replace(array('/туалетная вода/iu','/парфюмерная вода/iu'), array('edt','edp'), $data_p[$e]['name']);
			   $data_p[$e]['m_name'] = preg_replace('/\((.+)\)/i', '<span>($1)</span>', $data_p[$e]['m_name']);
		  }
	  }
	  
	  $data_n = array_get('t1.*,t2.name b_name,t3.id c_id,t3.url c_url,t4.name t_name',$type." t1 LEFT JOIN brands t2 ON t1.brand=t2.id LEFT JOIN Product_Cat t3 ON t1.cat=t3.id LEFT JOIN Product_Type t4 ON t1.type=t4.id WHERE t1.id > '".$id."' and t1.cat = '".$cat."' and t1.status='1' ORDER BY t1.id LIMIT 3",$type.'_Object_controller, data_n'); //Выборка следующей записи из БД, если следующей записи нет, то делаем выборку первой записи	
			 if(count($data_n)==0 or $data_n == $data_p) $data_n = array_get('t1.*,t2.name b_name,t3.id c_id,t3.url c_url,t4.name t_name',$type." t1 LEFT JOIN brands t2 ON t1.brand=t2.id LEFT JOIN Product_Cat t3 ON t1.cat=t3.id LEFT JOIN Product_Type t4 ON t1.type=t4.id WHERE t1.id < '".$id."' and t1.cat = '".$cat."' and t1.status='1' ORDER BY t1.id LIMIT 3",$type.'Object_controller, data_n');
			 
	  $c_datan = count($data_n);
	  if($c_datan>0)
	  {
		  for($e=0; $e<$c_datan; $e++)//добавление в массив модифицированного наименования товара
		  {
			   $data_n[$e]['name'] = htmlspecialchars($data_n[$e]['name'],ENT_QUOTES);
			   $data_n[$e]['m_name'] = preg_replace(array('/туалетная вода/iu','/парфюмерная вода/iu'), array('edt','edp'), $data_n[$e]['name']);
			   $data_n[$e]['m_name'] = preg_replace('/\((.+)\)/i', '<span>($1)</span>', $data_n[$e]['m_name']);
		  }
	  }	 
	  
	  
			 if($data_n==$data_p) $data_p = ''; //Если записи равны между собой, оставляем только одну
	  
	  if($data_p=='') $return = $data_n; elseif($data_n=='') $return = ''; else { $return = array_merge($data_p, $data_n); /*$return = array(0 => $data_p, 1 => $data_n);*/ }
	  
	  return $return;
  }
  
  public function Add_Char($cat,$id)
  {
	  $chars = $this->Get_Array("Product_Cat_controller Add_Char chars",$tab='Char_Groups',$columns='id,cat'," WHERE id IN (".$id.")");
	  
	  $chars_count = count($chars); $update = '';
	  for ($i=0; $i<$chars_count; $i++)
	  {
		  $chars[$i]['cat'] = explode(',',$chars[$i]['cat']); //echo '<pre>'; print_r($chars[$i]['cat']); echo '</pre>';
		  $chars[$i]['cat'][] = $cat; $chars[$i]['cat'] = array_filter($chars[$i]['cat']);
		  $chars[$i]['cat'] = implode(',',$chars[$i]['cat']); //echo $chars[$i]['cat'].'<br>';
		  
		  $return = update('Char_Groups',"cat='".$chars[$i]['cat']."' WHERE id='".$chars[$i]['id']."'","Product_Cat_controller Add_Char return[".$i."]");
	  }
	  
	  
  }

}