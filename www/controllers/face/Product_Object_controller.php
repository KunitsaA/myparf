<?

if(!$_SESSION['reviewed']) { $_SESSION['reviewed'] = array(); $_SESSION['reviewed'][] = $data['id']; }
else
{
	if(!in_array($data['id'], $_SESSION['reviewed']))
	{
		if(count($_SESSION['reviewed'])>2) { array_pop($_SESSION['reviewed']); }
		array_unshift($_SESSION['reviewed'], $data['id']);
	}
}

require_once 'classes/Page_Class.php'; 
if(!$Page) $Page = new Page();

$error_msg = 'Product_Object_controller';

/*=======================================================================================*/
$data['name'] = htmlspecialchars($data['name'],ENT_QUOTES);
/*=======================================================================================*/

/*=======================================================================================*/
$data['t_name'] = mb_strtolower($data['t_name'],'UTF-8');
/*=======================================================================================*/

/*=======================================================================================*/
switch($data['cat']){ case 1: $data['sex'] = 'женский'; break; case 2: $data['sex'] = 'мужской'; case 3: $data['sex'] = 'унисекс';}
/*=======================================================================================*/



/*=======================================================================================*/
$data['header'] = preg_replace(array('/ & /i','/&/i'), ' ', $data['header']);
$data['header'] = preg_replace('/('.$data['b_name'].')/i', '<span>$1</span>', $data['header']);
$data['header'] = preg_replace('/(\d{1,4}ml)/iu', '<span>$1</span>', $data['header']);


$pos = strpos($data['header'], '(');
if($pos!==false) { $data['subhead'] = substr($data['header'], $pos); $data['header'] = preg_replace('/\((.+)\)/i', '', $data['header']); } else { $data['subhead'] = ''; }

/*=======================================================================================*/

/*=======================================================================================*/
$arrto_bulk = explode(' ',$data['name']);
foreach($arrto_bulk as $bulk) { if(stripos($bulk, 'ml')!==false) $arr_bulk[] = $bulk; }

if(count($arr_bulk)>1) $data['bulk'] = preg_replace('/[()]/iu', ' ', implode(' + ',$arr_bulk)); else $data['bulk'] = preg_replace('/[()]/iu', ' ', $arr_bulk[0]);
/*=======================================================================================*/

$res = string_get('SUM(rating) sumr, COUNT(id) cid',"Reviews WHERE id_pr = '".$data['id']."' and status = '1'",$error_msg.' rating');
if($res['sumr']>0) $data['rating'] = round($res['sumr']/$res['cid']);

/*=======================================================================================*/
$nps = $Page->PrevNext($type,$data['id'],$data['cat']);
/*=======================================================================================*/

/*=======================================================================================*/
$urb = explode('/',$_SERVER['REQUEST_URI']); $urb = array_filter($urb); array_pop($urb); $urb = implode('/',$urb);
/*=======================================================================================*/

///Отзывы и капча
/*=======================================================================================*
$coms = $Page->Get_Array($error_msg.' coms','reviews',"*, (SELECT COUNT(id) FROM reviews WHERE id_pr='".$data['id']."' AND status='1') as cnt"," WHERE id_pr='".$data['id']."' AND status='1'","  ORDER BY id DESC LIMIT 5");
/*=======================================================================================*/

/*=======================================================================================*/
$capcha = $Page->Get_Array($error_msg.' capcha','capcha','*',""," ORDER BY RAND() LIMIT 4");
//////////////////////////////////////////////////////////

/*=======================================================================================*/
include_once ('classes/Product_Class.php'); 
if(!$Object) $Object = new Product();

$breadcrumbs = $Object->BreadCrumbs($type,$data['cat']);
/*=======================================================================================*/

//Сборка всех данных в шаблон контент
$html = includes('views/face/themes/default/content_tpl/'.$type.'_Object_content.php', array('data' => $data, 'nps' => $nps, 'urb' => $urb, 'breadcrumbs' => $breadcrumbs, 'coms' => $coms, 'capcha' => $capcha));
unset($chars,$nps,$urb,$brand,$breadcrumbs,$coms,$capcha);