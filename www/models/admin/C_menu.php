<?

/*=========================================================================
Вывод категорий статей
==========================================================================*/
//Выбираем данные из БД
$result = mysql_query("SELECT id, parent, name, status, url FROM Product_Cat ORDER BY name");
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
	   $tree .= '<a href="admin.php?c=Product_List&cat='.$cat['id'].'">'.$cat['name'].'</a>';
	   if($cat['status']==1): $img_status = 'Ok_icon.png'; $title_status = 'Ok'; else: $img_status = 'Not_icon.png'; $title_status = 'Недоступно'; endif;
	   $tree .= '<div class="Control"><a class="StatusLink" data-id="'.$cat['id'].'" data-status="'.$cat['status'].'" href="#"><img src="img/'.$img_status.'" title="'.$title_status.'" border="0" /></a><a class="EditLink" href="admin.php?c=Product_Cat&id='.$cat['id'].'"><img src="img/Edit_icon.png" title="Редактировать" border="0"  /></a><a class="DeleteLink" data-id="'.$cat['id'].'" href="#"><img src="img/Delete_icon.png" title="Удалить" border="0" /></a></div>';
       $tree .=  $this_check;
       $tree .= '</li>';
	   
    }
	$tree .= '</ul>';
    
  }
  else return null;
  return $tree;
}
