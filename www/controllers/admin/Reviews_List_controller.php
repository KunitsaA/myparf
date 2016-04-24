<?
$error_msg = 'Reviews_List_controller';

if($_POST)
{
	//echo '<pre>'; print_r($_POST['id']); echo '</pre>';
	$arr = $Object->Handle_Data($_POST);                    //Обработка данных перед использованием
	$Object->Delete($arr['id'],$name.'_controller, function DELETE',$type);
	header("Location: ".$_SERVER['HTTP_REFERER']);          //Выход к исходной странице
	if($sets['cach']==1)
	{
		include_once "models/admin/Del_Cach_model.php";//Подключение модели для очистки кэш файлов
		$p = array(); $p[] = '.c=Product_Object';
		DeletCach($control['home'],$p);
	}
	exit();//Завершаем работу скрипта
}
$where2 = ($_GET['show']) ? '' : " WHERE t1.status='0'"; $where = ($_GET['show']) ? '' : " WHERE status='0'";

require_once 'controllers/admin/Page_navigation_controller.php';

$data = $Object->Get_Array($name.'_controller, data',$type.' t1 LEFT JOIN Product t2 ON t1.id_pr=t2.id','t1.*, t2.name p_name',$where2, " ORDER BY t2.id, t1.id DESC LIMIT ".$quantity." OFFSET ".$list);

$html = includes('views/admin/themes/default/content_tpl/Reviews_List_content.php', array('data' => $data, 'page' => $page, 'pages' => $pages, 'limit' => $limit, 'uri' => $uri));