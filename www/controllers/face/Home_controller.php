<?

$error_msg = 'Home_controller';

require_once ('classes/Page_Class.php'); 

if(!$Page) $Page = new Page();

$objects = $Page->Get_Array($error_msg.' objects','Product t1 LEFT JOIN brands t2 ON t1.brand=t2.id LEFT JOIN Product_Cat t3 ON t1.cat=t3.id','t1.*,t2.name b_name,t3.url c_url,t3.id c_id'," WHERE t1.status='1' and t1.home='1'"," ORDER BY t1.id DESC");//Товары или Услуги из поиска

$c_obj = count($objects);
if($c_obj>0)
{
	$chars = $Page->Get_Array($error_msg.' chars','char_groups','*');
	$chars_count = count($chars); for ($i=0; $i<$chars_count; $i++) { $chars[$i]['cat'] = explode(',',$chars[$i]['cat']); }
}

//Сборка всех данных в шаблон контент
$html = includes('views/face/themes/default/blocks/Home_block.php', array('objects' => $objects, 'chars' => $chars));