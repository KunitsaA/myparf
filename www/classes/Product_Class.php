<?

require_once $control['home'].'classes/Page_Class.php';

class Product extends Page{
	
	/*private $to_tab = '_Cat';
	
	//Массив данных для хлебных крошек
	public function BreadCrumbs($type,$parent)
	{
		if($parent>0)
		{
			$type .= $this->to_tab;
		    $return = array_get('name,url,parent',$type." WHERE id IN (".$parent.") ORDER BY id",$type.'_controller, Breadcrumbs');
			if($return['parent']>0)
			{
				array_push($return, BreadCrumbs($type,$return['parent']));
			}
		}
		
		return $return;
	}*/
	
	public function BreadCrumbs($type,$id)
	{
		if($id>0):
		$res = mysql_query("SELECT id,url,name FROM ".$type."_Cat WHERE id='".$id."'");
		if(!$res) die(mysql_error());
		$row = mysql_fetch_assoc($res); mysql_free_result($res);
		
		$return = '';
		
		$return .= '<a href="catalog/'.$row['id'].'_'.$row['url'].'/">'.$row['name'].'</a>|';
		
		if($row['parent']!=0) { $return .= $this->BreadCrumbs($type,$row['parent']); }
		
		$return = explode('|',$return);
		
		$return = array_filter($return);//Чистим пустые элементы массива
		$return = array_reverse($return);//Переворачиваем массив
		
		$return = implode(" / ",$return);
		
		endif;
	
		return $return;
	}
	
}