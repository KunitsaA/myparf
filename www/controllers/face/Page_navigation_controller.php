<?

/*=====================Постраничная навигация=============================*/

      if (isset($_GET['page'])) { $page=intval($_GET['page']); }//$page - номер текущей страницы

      Error_Reporting(E_ALL & ~E_NOTICE);

      //$quantity = 21;//$quantity - количество выводимых объектов на страницу

      $limit = 4; //$limit - rоличество выводимых страниц

      if(!is_numeric($page)) $page=1;

      if ($page<1) $page=1;
      
	  if($c=='Page')
	  $co_pr = string_get('COUNT(id) as cid',$new_type,'Page_controller => Product_Cat controller => Page_navigation_controller => $co_pr');//Общее количество объектов для данного запроса
	  else
	  $co_pr = string_get('COUNT(id) as cid',$type." WHERE cat ='".$id."'".$where1.$where12.$where[0],$type.'_Cat controller => Page_navigation_controller => $co_pr');//Общее количество объектов для данного запроса

      $pages = $co_pr['cid']/$quantity;

      $pages = ceil($pages);//Общее количество страниц

      $pages++; 

      if ($page>$pages) $page = 1;

      if (!isset($list)) $list=0;

      $list=--$page*$quantity;
	  /*==========================Работа с урлами========================================================*/
      $uri = explode('?',$_SERVER['REQUEST_URI']);
      $uri[0] = preg_replace("/page-\d+\//", "", $uri[0]);//Заготовка url для новой страницы
	  
	  /*=================================================================================================*/
	  
