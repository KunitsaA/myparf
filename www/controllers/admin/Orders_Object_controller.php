<?
$error_msg = 'Orders_Object_controller';

$data = $Object->Get_Object($id,$error_msg.' data','Orders','*');;//Данные об объекте<br>

$details = $Object->Get_Array($error_msg.' details','Order_Det','*'," WHERE order_id='".$id."'",' ORDER BY id');//Данные об объекте

$dets_id = ''; $count_d = count($details); for($i=0; $i<$count_d; $i++){ $dets_id .= ($i!=($count_d-1)) ? $details[$i]['product_id'].',' : $details[$i]['product_id'];  }

$objects = $Object->Get_Array($error_msg.' objects','Product t1 LEFT JOIN Brands t2 ON t1.brand=t2.id LEFT JOIN Product_Cat t3 ON t1.cat=t3.id','t1.id,t1.url,t1.name,t1.char1,t1.char2,t1.char3,t1.char4,t1.char5,t1.char6,t1.char7,t1.char8,t1.char9,t1.char10,t1.imr1,t2.name bname,t3.id cid,t3.url curl'," WHERE t1.id IN (".$dets_id.")",' ORDER BY id DESC');

for($j=0; $j<$count_d; $j++)
{
	foreach($details as $d)
	{
		if($objects[$j]['id']==$d['product_id']) { $objects[$j]['cena'] = $d['cena']; $objects[$j]['cont'] = $d['count']; $objects[$j]['did'] = $d['id']; break; }
	}
}

unset($details,$dets_id,$count_d);

$status = $Object->Get_Array($error_msg.' status','Order_Status','*','',' ORDER BY id');//Данные об объекте


//Сборка всех данных в шаблон контент
$html = includes('views/admin/themes/default/content_tpl/Orders_Object_content.php', array('data' => $data, 'objects' => $objects, 'status' => $status));