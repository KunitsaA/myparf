<?
function get_moduls($dir,$pref)
{
	$skip = array('.', '..');
	$files = scandir($dir);
	
	$moduls = array();
	
	foreach($files as $file) {
		if(!in_array($file, $skip) && stripos($file, $pref)!==false)
		{
			$name_arr = array();
			$name_arr = preg_split ("/_/", $file, 2 );
			$work_name = '';
			$work_name = $name_arr[1];
			echo $dir.$file.'/descript.txt<br>';
			if(file_exists($dir.$file.'/descript.txt'))
			{
				$jfile = file_get_contents($dir.$file.'/descript.txt');
                $darr = json_decode($jfile); echo '<pre>'; print_r($darr); echo '</pre>'; $name = $darr->{'name'}; $descript = $darr->{'descript'};
				$moduls[] = array('modul' => $file, 'work_name' => $work_name, 'name' => $name, 'descript' => $descript);
			}
			else
			{
				$moduls[] = array('modul' => $file, 'work_name' => $work_name, 'name' => $work_name);
			}
		}
	}
	
	return $moduls; 
}
$plugs = get_moduls('moduls/','plug');
$fixs = get_moduls('moduls/','fix');

$mod_config = array();
if(file_exists('moduls/modules_config')) { $file = file_get_contents('moduls/modules_config'); $mod_config = unserialize($file); }

function array_json2file($arr,$filename)
{
	$str_value = json_encode($arr);
    
    $f = fopen($filename, 'w');
    fwrite($f, $str_value);
    fclose($f);
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Конфигурация модулей</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
$(document).ready(function(e) {
    
	
	
});
</script>
<style>
h1{
	text-align:center;
}
.confModuls{
	width:70%;
	margin:15px auto;
}
.confModuls .tbl_head td{
	padding:10px;
	font-size:16px;
	border:#000 solid 2px;
	border-right:none;
}
.confModuls .tbl_head td:last-child{
	border-right:#000 solid 2px;
}
.confModuls .tbl_body td{
	padding:10px;
	font-size:14px;
	border:#39C solid 2px;
	border-top:none;
	border-right:none;
}
.confModuls .tbl_body td:last-child{
	border-right:#39C solid 2px;
}
.button{
	height:30px;
	padding:0 10px;
}
</style>
</head>

<body>
<?
$arr = array("name" => "Заказ обратного звонка", "descript" => 'Виджет и обработчик "Заказ обратного звонка"');
//$arr = array_map("utf8_encode",$arr);
array_json2file($arr,'moduls/plug_back_call/descript.txt');
?>
<h1>Пробная версия конфигурации модулей</h1>
<form action="" method="post">
<table class="confModuls" border="0" cellspacing="0">
  <tr class="tbl_head">
    <td>Модуль</td>
    <td>Статус</td>
    <td>Расположение</td>
    <td>Условия расположения</td>
    <td>Способ подключения</td>
    <td>Условия отображения</td>
  </tr>
  <? $i=0; foreach($plugs as $plug): ?>
  <tr class="tbl_body" bgcolor="<? $color = ($i%2) ? '#D9FFFF' : '#FFFFFF'; echo $color; ?>">
    <td><b><?=$plug['name']?></b><br><?='-'.$plug['descript']?></td>
    <td><select name="status[<?=$i?>]"><option value="0">Откл</option><option value="1">Вкл</option></select></td>
    <? if (count($mod_config)>0): ?>
    <td><select name="nav[<?=$i?>]"><? foreach($fixs as $fix): ?><option value="<?=$fix['name']?>"><?=$fix['name']?></option><? endforeach ?></select></td>
    <td>&nbsp;</td>
    <td><select name="inc[<?=$i?>]"><option value="0">Php</option><option value="1">Ajax</option></select></td>
    <td>&nbsp;</td>
    <? else: ?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <? endif ?>
  </tr>
  <? $i++; endforeach ?>
</table>
<center><button class="button" type="submit">Сохранить конфигурацию</button></center>
</form>

<?
//echo '<pre>'; print_r($plugs); echo '</pre>';
//echo '<pre>'; print_r($fixs); echo '</pre>';
?>
</body>
</html>