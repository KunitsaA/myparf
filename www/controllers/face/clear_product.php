<?
session_start();
header('Content-Type: text/html; charset=utf-8');
///////////////////////Вытягивает ключи массива и по ним (ключ, значение)//////////////////////////////////
/*foreach ($_SESSION['tovars'] as $key => $value) {
      foreach ($value as $k => $v) {
               echo "Родитель-старший (дед)" . $key."<br />";
               echo "Родитель (в роли отца)" . $k."<br />";
               echo "Отпрыск (значение отца)" . $v."<br /><hr>";
			   //if ($v == $_POST['id']) { unset ($_SESSION['tovars'][$key]);}
      }
}*/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST)
{
      $keys = array_keys($_SESSION['tovars']);
      foreach($keys as $k => $v)
	  {
	  if ($_SESSION['tovars'][$v]['id'] == $_POST['del']) array_splice($_SESSION['tovars'], $v, 1);
      }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////

if (count($_SESSION['tovars'])>0)
{
      foreach($_SESSION['tovars'] as $tovars)
             {
	           $cont += $tovars['cont'];
	           $sum += $tovars['sum'];
             }
}

$_SESSION['count'] = intval($cont);
$_SESSION['sum'] = intval($sum);


echo json_encode($_SESSION);