<?
$error_msg = 'Orders_controller';

if(!$_SESSION['ord_status']) { $_SESSION['ord_status'] = 'all'; }
if(!$_SESSION['date_from']) { $_SESSION['date_from'] = '2015-01-01'; }
if(!$_SESSION['date_to']) { $_SESSION['date_to'] = date("Y-m-d"); }

$where = ''; $where2 = '';

if($_POST)
{
	if($_POST['status'])
	{
		if($_POST['status']!='') { $status = $_POST['status']; $_SESSION['ord_status'] = $status; } else { $status = $_SESSION['ord_status']; }
		if($_POST['date_from']!='') { $date_from = $_POST['date_from']; $_SESSION['date_from'] = $date_from; } else { $date_from = $_SESSION['date_from']; }
		if($_POST['date_to']!='') { $date_to = $_POST['date_to']; $_SESSION['date_to'] = $date_to; } else { $date_to = $_SESSION['date_to']; }
	}
	elseif($_POST['id'])
	{
		$arr = $Object->Handle_Data($_POST);                    //Обработка данных перед использованием

		$Object->Delete($arr['id'],'Order_List_controller, function DELETE','Orders');
		delete_dets($arr['id'],$error_msg.' delete_dets');
		
		header("Location: ".$_SERVER['HTTP_REFERER']);          //Выход к исходной странице
		
		exit();//Завершаем работу скрипта
	}
}
else
{
	$status = $_SESSION['ord_status'];
	$date_from = $_SESSION['date_from'];
	$date_to = $_SESSION['date_to'];
}

$status = intval($status);
$where2 .= " WHERE (t1.date between '".$date_from."' and '".$date_to."')"; $where .= " WHERE (date between '".$date_from."' and '".$date_to."')";
if($status!='') { $where2 .= " AND t1.status='".$status."'"; $where .= " AND status='".$status."'";  }

require_once 'controllers/admin/Page_navigation_controller.php';

$data = $Object->Get_Array($error_msg.' data','Orders t1 LEFT JOIN Order_Status t2 ON t1.status=t2.id','t1.*, t2.title',$where2," ORDER BY t1.id DESC LIMIT ".$quantity." OFFSET ".$list);//Данные об объекте

$stat_L = $Object->Get_Array($error_msg.' stat_L','Order_Status','*','',' ORDER BY id');//Данные об объекте


//Сборка всех данных в шаблон контент
$html = includes('views/admin/themes/default/content_tpl/Orders_List_content.php', array('data' => $data, 'stat_L' => $stat_L, 'page' => $page, 'pages' => $pages, 'limit' => $limit, 'uri' => $uri));