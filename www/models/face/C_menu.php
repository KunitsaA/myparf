<?

/*=========================================================================
Вывод категорий статей
==========================================================================*/
//Выбираем данные из БД
$result = mysql_query("SELECT id, parent, name, url FROM Product_Cat WHERE status='1' ORDER BY name");
//Если в базе данных есть записи, формируем массив
if   (mysql_num_rows($result) > 0){
$cats = array();
//В цикле формируем массив разделов, ключом будет id родительской категории
while($cat =  mysql_fetch_assoc($result))
      $cats[$cat['parent']][] =  $cat;
}

                    /*============================*/
function build_trees($cats,$parent)
{
  if(is_array($cats) and isset($cats[$parent])){
    $tree = '<ul>';
    foreach($cats[$parent] as $cat){
	   
	   $this_check = build_trees($cats,$cat['id']); if($this_check!='') $class = 'class="has-sub"'; else $class = '';
	   $tree .= '<li '.$class.'>';
       $tree .= '<a href="catalog/'.$cat['id'].'_'.$cat['url'].'/">'.$cat['name'].'</a>';
       $tree .=  $this_check;
       $tree .= '</li>';
	   
    }
	$tree .= '</ul>';
    
  }
  else return null;
  return $tree;
}
