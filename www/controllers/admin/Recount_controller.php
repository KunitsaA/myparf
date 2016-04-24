<?
$file = file_get_contents('control.txt'); $control = unserialize($file);
require_once $control['home'].'models/admin/bd.php';

function Recount($data,$ordid)
{
	$array = array(); $det_id = ''; $cd = count($data); $all_ztotal = 0; $all_total = 0;
	
	for($i=0; $i<$cd; $i++)
	{
		$res = mysql_query("UPDATE Order_Det SET cont='".$data[$i]['cont']."' WHERE id='".$data[$i]['det_id']."'"); if(!$res) die(mysql_error());
		
		$array[$i] = array('det_id'=>$data[$i]['det_id'], 'ztotal'=>$data[$i]['cont']*$data[$i]['z_cena'], 'total'=>$data[$i]['cont']*$data[$i]['cena']);
		$all_ztotal += $data[$i]['cont']*$data[$i]['z_cena'];
		$all_total += $data[$i]['cont']*$data[$i]['cena'];
	}
	
	$result = mysql_query("UPDATE Orders SET total='".$all_total."' WHERE id='".$ordid."'"); if(!$result) die(mysql_error());
	
	$return = array(); $return['all_ztotal'] = $all_ztotal; $return['all_total'] = $all_total; $return['array'] = $array;
	
	return $return;	
}
function Change_Status($status,$ordid)
{
	$result = mysql_query("UPDATE Orders SET status='".$status."' WHERE id='".$ordid."'"); if(!$result) die(mysql_error());
	
	return $result;
}
if($_POST)
{
	if($_POST['array'])
	{
		$array = $_POST['array']; $ordid = $_POST['ordid']; $return = Recount($array,$ordid);
	}
	elseif($_POST['Select'])
	{
		$status = $_POST['Select']; $ordid = $_POST['ordid']; $return = Change_Status($status,$ordid);
	}
}
echo json_encode($return);