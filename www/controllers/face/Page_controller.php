<?
if($id==1) { include_once 'controllers/face/Home_controller.php'; include_once 'controllers/face/Articles_Block_controller.php'; }
else
{
	switch($_GET['url']):
	     case 'dostavka': include_once 'controllers/face/Delivery_controller.php'; break;
		 case 'cart':     include_once 'controllers/face/Cart_controller.php'; break;
		 case 'search':   include_once 'controllers/face/Search_controller.php'; break;
		 case 'order':    include_once 'controllers/face/Order_controller.php'; break;
		 case 'spasibo':  include_once 'controllers/face/Spasibo_controller.php'; break;
	endswitch;
}

//Сборка всех данных в шаблон контент
$html = includes('views/face/themes/default/content_tpl/'.$name.'_content.php', array('data' => $data, 'html' => $html, 'html2' => $html2));



