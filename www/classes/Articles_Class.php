<?

require_once 'classes/Page_Class.php';

class Articles extends Page{
	
	  //Вставки строки в таблицу "Страницы"
  //$data - массив переменных
  //$error_msg - сообщение о координатах ошибки
  public function Insert($data,$error_msg,$tab='Articles')
  {
	  $return = insert('Page',"(status, cat, home, url, name, title, meta_d, meta_k, header, text, views, date) VALUES ('".$data['status']."', '".$data['cat']."', '".$data['home']."', '".$data['url']."', '".$data['name']."', '".$data['title']."', '".$data['meta_d']."', '".$data['meta_k']."', '".$data['header']."', '".$data['text']."', '".$data['views']."', '".$data['date']."')",$error_msg);
	  
	  $return = mysql_insert_id(); return $return;
	  
	  $return = null;
  }
  //Редактирование таблицы "Страницы". Обновление строки с id = $id
  //$data - массив переменных
  //$error_msg - сообщение о координатах ошибки
  public function Update($id,$data,$error_msg,$tab='Articles')
  {
	  $return = update($tab,"status='".$data['status']."', cat='".$data['cat']."', home='".$data['home']."', title='".$data['title']."', meta_d='".$data['meta_d']."', meta_k='".$data['meta_k']."', header='".$data['header']."', text='".$data['text']."', views='".$data['views']."', date='".$data['date']."' WHERE id='".$id."'",$error_msg);
	  
	  return $return;
	  
	  $return = null;
  }
	
}