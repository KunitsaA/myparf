<?
session_start();
//unset($_SESSION['tovars']);
if ($_POST)
{
	if(isset($_POST['del']))//удаление товара из корзины
	{
		$keys = array_keys($_SESSION['tovars']);
            foreach($keys as $k => $v)
	        {
	           if ($_SESSION['tovars'][$v]['id'] == $_POST['del']) array_splice($_SESSION['tovars'], $v, 1);
            }
		ksort($_SESSION['tovars']);
	}
	else if(isset($_POST['clear']))//удаление всех товаров из корзины
	{
		$_SESSION['tovars'] = array();
	}
	else if(isset($_POST['n_cont']))//Смена количества нужного товара
	{
		$keys = array_keys($_SESSION['tovars']);
            foreach($keys as $k => $v)
	        {
	           if ($_SESSION['tovars'][$v]['id'] == $_POST['n_cont']){
				   $_SESSION['tovars'][$v]['count'] = $_POST['vali'];
				   $_SESSION['tovars'][$v]['sum'] = $_SESSION['tovars'][$v]['cena'] * $_SESSION['tovars'][$v]['count'];
				   $_SESSION['nsum'] = $_SESSION['tovars'][$v]['sum'];
			   }
            }
	}
	else//Добавление товара в корзину
	{
		$_SESSION['tovars'][] = array('id' => $_POST['id'], 'cena' => $_POST['cena'], 'count' => $_POST['count'], 'sum' => $_POST['count']*$_POST['cena']);
	}
	  
}


if (count($_SESSION['tovars'])>0)//Получение общего количества товаров в корзине и общей суммы
{
      foreach($_SESSION['tovars'] as $tovars)
	  {
	      $count += $tovars['count']; $sum += $tovars['sum'];
	  }
	  
	  $_SESSION['count'] = $count;
      $_SESSION['sum'] = $sum;
}
else
{
	$_SESSION['count'] = 0;
    $_SESSION['sum'] = 0;
}

echo json_encode($_SESSION);