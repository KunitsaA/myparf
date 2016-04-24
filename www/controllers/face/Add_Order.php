<?

$file = file_get_contents('control.txt'); $control = unserialize($file);
require_once $control['home'].'models/face/bd.php';
require_once $control['home'].'models/face/Base_model.php';
require_once $control['home'].'models/face/Settings_model.php'; $sets = get_settings($control); //Подключаем модель для получения настроек и вытаскиваем
require_once $control['home'].'models/face/view.php';//Подключение шаблонов
require_once $control['home'].'classes/Page_Class.php';

if(!$Page) $Page = new Page();
//header('Content-Type: text/html; charset=utf-8');

if($_POST)
{
	  $arr = $Page->Handle_Data($_POST);
 
	  $arr['total']  = $_SESSION['sum']; $arr['date']   = date('Y-m-d'); $arr['status'] = 1;
	  
	  $insert_id = $Page->Insert($arr,'Add_Order, insert order','Orders');//Запись
	  
	  $keys = count($_SESSION['tovars']); $value = '';
	  
	  for ($i=0; $i<$keys; $i++)
	  {
		  $value .= ($i==($keys-1)) ? "('".$insert_id."', '".$_SESSION['tovars'][$i]['id']."', '".$_SESSION['tovars'][$i]['cena']."', '".$_SESSION['tovars'][$i]['count']."')" : "('".$insert_id."', '".$_SESSION['tovars'][$i]['id']."', '".$_SESSION['tovars'][$i]['cena']."', '".$_SESSION['tovars'][$i]['count']."'), ";
			
	  }
	  
	  $return = Insert_Order_Dets($value);
}
echo json_encode($return);

//Отправка сообщения на почту

	$delivery = $Page->Get_Object($arr['delivery'],'Add_Order, delivery','Delivery','name');
    $to_adm = $sets['email'];//- из settings email
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$subject_adm = 'Новый заказ в магазине '.$sets['name'].'';
	
	//Сборка всех данных в шаблон контент
	$message_adm = includes($control['home'].'views/face/themes/default/blocks/Order_Mail_block.php', array('arr' => $arr, 'delivery' => $delivery, 'sets' => $sets, 'control' => $control));
	
	//Отправка сообщения на почту//
	$send = mail($to_adm,$subject_adm,$message_adm,$headers);
	
	//Отправка сообщения на почту покупателя//
	if($sets['status_post']==1 && $arr['email']!='')
	{
		$to_cl = $arr['email']; $subject_cl = 'Ваш заказ в магазине '.$sets['name'].' - принят';
		$message_cl = includes($control['home'].'views/face/themes/default/blocks/Order_Mail_block2.php', array('arr' => $arr, 'delivery' => $delivery, 'sets' => $sets, 'control' => $control));
		
	    $send = mail($to_cl,$subject_cl,$message_cl,$headers);
	}

session_unset();

//Отправка сообщения на телефон
//include 'smssend.php';	
//Отправка сообщения на телефон//