<?
//$_SESSION = array();
require_once 'classes/Page_Class.php'; 

if(!$Page) $Page = new Page();

//Название ошибки по умолчанию
$error_msg = 'Search_controller';

if($_GET['search'])
{
	$_GET['search'] = preg_replace(array('/ union /iu','/ select /iu','/ drop /iu','/ delete /iu','/ update /iu','/ insert /iu','/=/iu'), '', $_GET['search']);
	$search = mysql_real_escape_string(trim($_GET['search']));
	$search = explode(" ", $search);
	
	if(($key = array_search('&',$search)) !== FALSE) unset($search[$key]); $search = array_filter($search);
	
	$s_str = ''; foreach($search as $ser){ $s_str .= '*'.$ser.'*'; }
	
}

$quantity = 24;//Кол-во товаров выводимых на страницу

//файл с данными для постраничной навигации
include_once 'controllers/face/Page_navigation_search_controller.php';

//Товары или Услуги в этой категории
$objects = $Page->Get_Array($error_msg.' objects','Product t1 LEFT JOIN Brands t2 ON t1.brand=t2.id LEFT JOIN Product_Cat t3 ON t1.cat=t3.id LEFT JOIN Product_Type t4 ON t1.type=t4.id',"t1.*, MATCH (t1.name) AGAINST ('".$s_str."' IN BOOLEAN MODE) as rel,t2.name b_name,t3.id c_id,t3.url c_url,t4.name t_name"," WHERE MATCH (t1.name) AGAINST ('".$s_str."' IN BOOLEAN MODE)"," ORDER BY rel DESC LIMIT ".$quantity." OFFSET ".$list."");

$c_obj = count($objects);
if($c_obj>0)
{	
	for($e=0; $e<$c_obj; $e++)//добавление в массив модифицированного наименования товара
	{
		 $objects[$e]['name'] = $objects[$e]['name'];
		 $objects[$e]['m_name'] = preg_replace(array('/туалетная вода/iu','/парфюмерная вода/iu'), array('edt','edp'), $objects[$e]['name']);
		 $objects[$e]['m_name'] = preg_replace('/\((.+)\)/i', '<span>($1)</span>', $objects[$e]['m_name']);
	}
}

$arr = explode('/',$_SERVER['REQUEST_URI']); $arr = array_filter($arr); array_pop($arr); $url = implode('/',$arr);


//Сборка всех данных в шаблон контент
$html2 = includes('views/face/themes/default/content_tpl/Product_Search_content.php', array('data' => $data, 'data_b' => $data_b, 'objects' => $objects, 'categories' => $categories, 'check' => $check, 'url' => $url, 'breadcrumbs' => $breadcrumbs, 'page' => $page, 'pages' => $pages, 'limit' => $limit, 'uri' => $uri, 'urb' => $urb, 'prices' => $prices, 'chars' => $chars, 'chars_d' => $chars_d, 'brands' => $brands, 'arr' => $arr, 'catalog' => $catalog, 'types' => $types, 'co_pr' => $co_pr, 'myobjects' => $myobjects));