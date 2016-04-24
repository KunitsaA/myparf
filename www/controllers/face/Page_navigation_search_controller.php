<?

/*=====================Постраничная навигация=============================*/

      if (isset($_GET['page'])) { $page=intval($_GET['page']); }//$page - номер текущей страницы

      //Error_Reporting(E_ALL & ~E_NOTICE);

      $limit = 4; //$limit - rоличество выводимых страниц

      if(!is_numeric($page)) $page=1;

      if ($page<1) $page=1;
      
	  $co_pr = string_get('COUNT(id) as cid',"Product WHERE MATCH (name) AGAINST ('".$s_str."' IN BOOLEAN MODE)",$error_msg.' Page_navigation_search_controller co_pr');//Общее количество объектов для данного запроса

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
	  
