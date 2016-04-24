<?
$file = file_get_contents('control.txt'); $control = unserialize($file);
require_once $control['home'].'/models/face/Settings_model.php'; $sets = get_settings($control); //Подключаем модель для получения настроек и вытаскиваем

$to = $sets['email'];//- из settings email
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

if($_POST)
{
	
	$subject = 'Заказ обратного звонка';
	$message = '<table width="400" border="0" cellspacing="0">
                      <tr>
                        <td valign="top" width="100"><p style="margin:10px 0 0 0;">Имя:</p></td>
                      
                        <td valign="top"><p style="margin:10px 0 0 0;">'.$_POST['name'].'</p></td>
                      </tr>
					  <tr>
                        <td valign="top"><p style="margin:10px 0 0 0;">Телефон:</p></td>
                      
                        <td valign="top"><p style="margin:10px 0 0 0;">'.$_POST['phone'].'</p></td>
                      </tr>
                    </table>
';

	
	$send = mail($to,$subject,$message,$headers);
	
}
echo json_encode($send);