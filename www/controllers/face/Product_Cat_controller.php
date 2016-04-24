<?
//$_SESSION = array();
require_once 'classes/Page_Class.php'; 

if(!$Page) $Page = new Page();

//Название ошибки по умолчанию
$error_msg = 'Product_Cat_controller';

//файл с обработкой дополнительных входящих данных (сортировка, фильтрации и т.д) 
include_once 'controllers/face/Inc_Product_Cat_controller.php';

//файл с данными для постраничной навигации
include_once 'controllers/face/Page_navigation_controller.php';

//Товары или Услуги в этой категории
$objects = $Page->Get_Array($error_msg.' objects',$type.' t1 LEFT JOIN brands t2 ON t1.brand=t2.id LEFT JOIN Product_Cat t3 ON t1.cat=t3.id LEFT JOIN Product_Type t4 ON t1.type=t4.id','t1.*,t2.name b_name,t3.id c_id,t3.url c_url,t4.name t_name'," WHERE t1.cat = '".$id."' and t1.status='1'".$where2," ORDER BY ".$sort." LIMIT ".$quantity." OFFSET ".$list."");

$c_obj = count($objects);
if($c_obj>0)
{	
	for($e=0; $e<$c_obj; $e++)//добавление в массив модифицированного наименования товара
	{
		 $objects[$e]['name'] = $objects[$e]['name'];
		 $objects[$e]['m_name'] = preg_replace(array('/туалетная вода/iu','/парфюмерная вода/iu'), array('edt','edp'), $objects[$e]['name']);
		 $objects[$e]['m_name'] = preg_replace('/\((.+)\)/i', '<span>($1)</span>', $objects[$e]['m_name']);
	}
	
	//Выборка максимальной и минимальной цены из таблицы "Товары" по условию
	$prices = $Page->Get_Array($error_msg.' prices',$type,'MAX(IF(s_cena<>0,s_cena,cena)) AS max, MIN(IF(s_cena<>0,s_cena,cena)) AS min'," WHERE cat = '".$id."' and status='1'".$where1); $prices = $prices[0];
	
	//Выбока брендов/производителей для текущей категории товаров и кол-во товаров по каждому бренду
	$brands = $Page->Get_Array('Product_Cat_controller Get_Brands obrands',$type.' t1 LEFT JOIN brands t2 ON t1.brand=t2.id','COUNT(t1.id) cid, t1.brand, t2.name b_name'," WHERE t1.cat = '".$id."'"," GROUP BY t1.brand ORDER BY t2.name");
	
	//Выборка типов и количества товаров в каждом из них
	$types = $Page->Get_Array('Product_Cat_controller Get_Brands types',$type.'_Type','id, name',""," ORDER BY id");
	$types_c = $Page->Get_Array('Product_Cat_controller Get_Brands types',$type.' t1 LEFT JOIN Product_Type t2 ON t1.type=t2.id','COUNT(t1.id) cid, t1.type'," WHERE t1.cat = '".$id."'".$where3," GROUP BY t1.type ORDER BY t2.id");
	
	//Совмешение данных по типам из двух массивов в один
	$count_types = count($types); $count_types_c = count($types_c);
	for($i=0; $i<$count_types; $i++)
	{
		for($j=0; $j<$count_types_c; $j++){ if($types[$i]['id']==$types_c[$j]['type']) $types[$i]['cid'] = $types_c[$j]['cid']; }
	}
	
	//Определение строки url для атрибута href в ссылках на бренды
	$urb = $uri;
	$urb[0] = preg_replace("/brand-\d+-[^\/]+\//", "", $urb[0]);
}


$arr = explode('/',$_SERVER['REQUEST_URI']); $arr = array_filter($arr); array_pop($arr); $url = implode('/',$arr);

//Хлебные крошки
include_once ('classes/Product_Class.php'); 
if(!$Object) $Object = new Product();

$breadcrumbs = $Object->BreadCrumbs($type,$data['parent']);




//Сборка всех данных в шаблон контент
$html = includes('views/face/themes/default/content_tpl/Product_Cat_content.php', array('data' => $data, 'data_b' => $data_b, 'objects' => $objects, 'categories' => $categories, 'check' => $check, 'url' => $url, 'breadcrumbs' => $breadcrumbs, 'page' => $page, 'pages' => $pages, 'limit' => $limit, 'uri' => $uri, 'urb' => $urb, 'prices' => $prices, 'chars' => $chars, 'chars_d' => $chars_d, 'brands' => $brands, 'arr' => $arr, 'catalog' => $catalog, 'types' => $types, 'co_pr' => $co_pr, 'myobjects' => $myobjects));