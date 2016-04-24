<?
$error_msg = 'Cart_controller';

require_once ('classes/Page_Class.php'); 

if(!$Page) $Page = new Page();

$product_id = array();
$count_poduct = count($_SESSION['tovars']);

if($count_poduct>0)
{
	for ($i=0; $i<$count_poduct; $i++) { $product_id[] = $_SESSION['tovars'][$i]['id']; } $product_id = implode(',',$product_id);
	
	//$objects = $Page->Get_Array($error_msg.' objects','Product t1 LEFT JOIN Brands t2 ON t1.brand=t2.id LEFT JOIN Product_Cat t3 ON t1.cat=t3.id','t1.*,t2.name b_name,t3.url c_url,t3.id c_id'," WHERE t1.id IN (".$product_id.")","");//Товары или Услуги в этой категории
	
	$objects = $Page->Get_Array($error_msg.' objects','Product t1 LEFT JOIN Brands t2 ON t1.brand=t2.id LEFT JOIN Product_Cat t3 ON t1.cat=t3.id LEFT JOIN Product_Type t4 ON t1.type=t4.id','t1.*,t2.name b_name,t3.id c_id,t3.url c_url,t4.name t_name'," WHERE t1.id IN (".$product_id.")"," ORDER BY t1.name");//Товары или Услуги в этой категории
	
	$c_obj = count($objects);
	
	if($c_obj>0)
	{
		for($e=0; $e<$c_obj; $e++)//добавление в массив модифицированного наименования товара
		{
			 $objects[$e]['name'] = $objects[$e]['name'];
			 $objects[$e]['m_name'] = preg_replace(array('/туалетная вода/iu','/парфюмерная вода/iu'), array('edt','edp'), $objects[$e]['name']);
			 $objects[$e]['m_name'] = preg_replace('/\((.+)\)/i', '<span>($1)</span>', $objects[$e]['m_name']);
		}
		
		$chars = $Page->Get_Array($error_msg.' chars','char_groups','*');
		$chars_count = count($chars); for ($i=0; $i<$chars_count; $i++) { $chars[$i]['cat'] = explode(',',$chars[$i]['cat']); }
	}
	
	for($i=0; $i<$c_obj; $i++)
	{
		foreach($_SESSION['tovars'] as $product)
		{
			if($objects[$i]['id'] == $product['id']) { $objects[$i]['count'] = $product['count']; $objects[$i]['sum'] = $product['sum']; $objects[$i]['cena'] = $product['cena']; }
		}
    }
	
	$tot_c = $_SESSION['count'];
	$tot_s = $_SESSION['sum'];
}

$html2 = includes('views/face/themes/default/content_tpl/Cart_content.php', array('objects' => $objects, 'chars' => $chars, 'tot_c' => $tot_c, 'tot_s' => $tot_s));