<?
$error_msg = 'Delivery_controller';

$delivs = $Page->Get_Array($error_msg.'_delivs','Delivery','*'," WHERE status='1'",' ORDER BY id DESC');

//Сборка всех данных в шаблон контент
$html2 = includes('views/face/themes/default/blocks/Delivery_block.php', array('delivs' => $delivs));