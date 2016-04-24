<?
$file = file_get_contents('control.txt'); $control = unserialize($file);
require_once $control['home'].'models/face/bd.php';
require_once $control['home'].'models/face/Base_model.php';
require_once $control['home'].'models/face/view.php';//Подключение шаблонов
require_once $control['home'].'classes/Page_Class.php';
	
$reviews = $_SESSION['reviewed'];
$c_rew = count($reviews);

if($c_rew>0)
{
	$Page = new Page();
	
	$rew = '';  for($i=0; $i<$c_rew; $i++) { if($i!=0) $rew .= ($i==($c_rew-1)) ? $reviews[$i] : $reviews[$i].','; }
	
	$objects = $Page->Get_Array($error_msg.' objects','Product t1 LEFT JOIN brands t2 ON t1.brand=t2.id LEFT JOIN Product_Cat t3 ON t1.cat=t3.id','t1.*,t2.name b_name,t3.url c_url,t3.id c_id'," WHERE t1.id IN (".$rew.")","");//Товары или Услуги из поиска
	
	//Сборка всех данных в шаблон контент
	$html = includes($control['home'].'views/face/themes/default/blocks/Reviewed_block.php', array('objects' => $objects));
	
	echo json_encode($html);
}
exit();