<?
$error_msg = 'Order_controller';

require_once 'classes/Page_Class.php'; 

if(!$Page) $Page = new Page();

$delives = $Page->Get_Array($error_msg.' Delives',"Delivery WHERE status = '1'","*",''," ORDER BY id");//Выбираем вложенные Категории
$p_ms = $Page->Get_Array($error_msg.' p_ms',"Pay_Methods","*");//Выбираем вложенные Категории

//Сборка всех данных в шаблон контент
$html2 = includes('views/face/themes/default/content_tpl/Order_content.php', array('delives' => $delives, 'p_ms' => $p_ms));