<?

/*=====================Постраничная навигация=============================*/

      if (isset($_GET['page'])) { $page=intval($_GET['page']); }//$page - номер текущей страницы

      Error_Reporting(E_ALL & ~E_NOTICE);

      $quantity = 30;//$quantity - количество выводимых объектов на страницу

      $limit = 4; //$limit - rоличество выводимых страниц

      if(!is_numeric($page)) $page=1;

      if ($page<1) $page=1;
      
	  $co_pr = string_get('COUNT(id) as cid',$type.$where,$type.'_Cat controller => Page_navigation_controller => co_pr');//Общее количество объектов для данного запроса

      $pages = $co_pr['cid']/$quantity;

      $pages = ceil($pages);//Общее количество страниц

      $pages++; 

      if ($page>$pages) $page = 1;

      if (!isset($list)) $list=0;

      $list=--$page*$quantity;
	  /*==========================Работа с урлами========================================================*/
      $uri = preg_replace("/&page=\d+/", "", $_SERVER['REQUEST_URI']); $uri = preg_replace("/&brand=\d+/", "", $uri);
	  /*=================================================================================================*/
	  
