<?
$error_msg = 'Product_List_controller';
if($_POST)
{
	//echo '<pre>'; print_r($_POST['id']); echo '</pre>';
	$arr = $Object->Handle_Data($_POST);                    //Обработка данных перед использованием
	$Object->Delete_Images($control['home_dir'],$control['db_name'],$type,$arr['id']);
	$Object->Delete($arr['id'],$name.'_controller, function DELETE',$type);
	header("Location: ".$_SERVER['HTTP_REFERER']);          //Выход к исходной странице
	
	if($sets['cach']==1)
	{
		include_once 'models/admin/Del_Cach_model.php';//Подключение модели для очистки кэш файлов
		AllDeletCach($control['home']);
	}
	exit();//Завершаем работу скрипта
}
$cat = ($_GET['cat']) ? $_GET['cat'] : 0 ; $where = ($_GET['cat']) ? " WHERE cat='".$cat."'" : '';
$where .= ($_GET['brand']) ? " AND brand='".$_GET['brand']."'" : '';

require_once 'models/admin/C_menu.php'; $catalog = build_trees($cats,0);

require_once 'controllers/admin/Page_navigation_controller.php';

$brands = $Object->Get_Array($name.'_controller, brands',$type.' t1 LEFT JOIN brands t2 ON t1.brand=t2.id','COUNT(t1.id) cid, t1.brand, t2.name b_name'," WHERE t1.cat='".$_GET['cat']."' and t1.status='1'"," GROUP BY t1.brand ORDER BY t2.name");

$objects = $Object->Get_Array($name.'_controller, objects',$type,'id,name,status',$where, " ORDER BY id DESC LIMIT ".$quantity." OFFSET ".$list);

$html = includes('views/admin/themes/default/content_tpl/'.$name.'_content.php', array('categs' => $categs, 'catalog'=>$catalog, 'objects' => $objects, 'brands' => $brands, 'page' => $page, 'pages' => $pages, 'limit' => $limit, 'uri' => $uri));