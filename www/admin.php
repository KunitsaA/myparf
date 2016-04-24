<?
session_start(); //session_unset();
$file = file_get_contents('controllers/admin/control.txt'); $control = unserialize($file);
//$control = array(home=>"/home/parfumis.ru2/www/",host=>"parfumis.ru2",db_name=>"parfumis");
require_once 'models/face/view.php';//Подключение шаблонов
require_once 'controllers/admin/Base_controller.php';//Основной контроллер

if(!($_SESSION['user']))
{
	if($_POST)
	{
		$login = $_POST['login']; $pass = $_POST['pass'];
		require_once 'models/admin/Settings_model.php'; $sets = get_settings($control); //Подключаем модель для получения настроек и вытаскиваем
		/*echo '<pre>'; print_r($_POST); echo '</pre>'; echo md5($_POST['pass']).'<br>';
		echo '<pre>'; print_r($sets); echo '</pre>'; echo $sets['pass'].'<br>';*/
		if($login == $sets['login'] && md5($pass) == $sets['pass']) { $_SESSION['user'] = $login; header("Location: admin.php"); exit(); }
		else
		{
			$data=array(); $data['login'] = $login; $data['pass'] = $pass;
			$data['login_ans'] = ($login != $sets['login']) ? 'not' : '';
			$data['pass_ans'] = (md5($pass) != $sets['pass']) ? 'not' : '';
		}
	}
	$tpl = includes('views/admin/themes/default/blocks/In_block.php', array('data' => $data, 'sets'=>$sets));//Сборка всех данных в шаблон страницы
	echo $tpl;//Вывод страницы на экран
}
else
{
	
    
	/*=======================================================================
					  Поключение общего шаблона страницы
	========================================================================*/
	
	$tpl = includes('views/admin/themes/default/index_tpl.php', array('Head' => $Head, 'Header' => $Header, 'Content' => $Content, 'Footer' => $Footer));//Сборка всех данных в шаблон страницы
	echo $tpl;//Вывод страницы на экран
}