<?

if(!$_GET['sort']) { $sort = "t1.name"; }//Определение сортировки товаров при выборке из БД
else
{
	switch($_GET['sort']):
		case 1: 
		      $sort = "t1.name"; break;
	    case 2:
			  $sort = "t1.name DESC"; break;
		case 3:
		      $sort = "IF(t1.s_cena<>0,t1.s_cena,t1.cena)"; break;
		case 4:
		      $sort = "IF(t1.s_cena<>0,t1.s_cena,t1.cena) DESC"; break;
	endswitch;
}

$quantity = 24;//Кол-во товаров выводимых на страницу

if($_GET['brand'])//Если выбран бренд/производитель то создаем условие для выборки из БД
{
	$brand = intval($_GET['brand']);
	$where1 .= " and brand='".$brand."'";
	$where2 .= " and t1.brand='".$brand."'";
	$where3 .= " and t1.brand='".$brand."'";
}

if($_GET['type'])//Если выбран тип(ы), то создаем условие для выборки из БД
{
	$types = mysql_real_escape_string($_GET['type']);
	$where1 .= " and type IN (".$types.")";
	$where2 .= " and t1.type IN (".$types.")";
}

if($_GET['min'])//Если указана минимальная цена, то создаем условие для выборки из БД
{
	$min = intval($_GET['min']);
	$where12 .= ' and IF(s_cena<>0,s_cena,cena) > '.($min-1);
	$where2 .= ' and IF(t1.s_cena<>0,t1.s_cena,t1.cena) > '.($min-1);
	$where3 .= ' and IF(t1.s_cena<>0,t1.s_cena,t1.cena) > '.($min-1);
}

if($_GET['max'])//Если указана максимальная цена, то создаем условие для выборки из БД
{
	$max = intval($_GET['max']);
	$where12 .= ' and IF(s_cena<>0,s_cena,cena) < '.($max+1);
	$where2 .= ' and IF(t1.s_cena<>0,t1.s_cena,t1.cena) < '.($max+1);
	$where3 .= ' and IF(t1.s_cena<>0,t1.s_cena,t1.cena) < '.($max+1);
}