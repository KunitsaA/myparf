<?
$file = file_get_contents('controllers/admin/control.txt'); $control = unserialize($file);
include_once 'models/face/bd.php'; 
include_once 'models/admin/Base_model.php'; 

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Документ без названия</title>
<style>
.td{
	border-bottom:#000 solid 1px;
}
</style>
</head>

<body>

<? include_once 'classes/CSV_Class.php'; ?>
<?

try {
    $csv = new CSV("Parfum11.csv"); //Открываем наш csv
    /**
     * Чтение из CSV  (и вывод на экран в красивом виде)
     */
    
    $get_csv = $csv->getCSV(); 
	$brand = 23;
?>
	
	<table width="70%" border="0" cellspacing="0">
  <tr>
    <td>№</td>
    <td>Наименование</td>
    <td>Тип</td>
    <td>Кат</td>
    <td>Закупочная цена</td>
    <td>Закупочная с %</td>
    <td>Продажа</td>
    <td>Продажа без ск</td>
  </tr>
  


<?	$a = 1; $str_tobd = '';
    foreach ($get_csv as $value): if($value[3]>0): //Проходим по строкам
	$value[0] = mb_convert_encoding($value[0], 'UTF-8', 'Windows-1251'); $value[0] = str_ireplace(array(" Товар","\""), "", $value[0]); $value[3] = (float)$value[3]; //$value[0] = str_ireplace(array(" М Товар"," Ж Товар"," МЖ Товар","\""), "", $value[0]);
	
	if(stripos($value[0],' Набор') or stripos($value[0],' набор'))
	{
		$value[4] = 3;
	}
	elseif(stripos($value[0],' Парфюмерная вода спрей') or stripos($value[0],' Парфюмированная вода') or stripos($value[0],' Парфюмерная вода') or stripos($value[0],' парфюмерная вода') or stripos($value[0],' парфюмированная вода') or stripos($value[0],' парфюмерная'))
	{
		$patterns = array(' Парфюмированная вода',' Парфюмерная вода',' спрей',' парфюмерная вода', ' парфюмированная вода',' парфюмерная',' Вода');
	    $value[0] = str_ireplace($patterns, "", $value[0]);
		$value[4] = 1;
	}
	elseif(mb_stripos($value[0],' Освежающая туалетная вода') or mb_stripos($value[0],' Туалетная вода спрей') or mb_stripos($value[0],' Туалетная вода') or stripos($value[0],' туалетная вода') or stripos($value[0],' туалетная'))
	{
		$patterns = array(' Освежающая туалетная вода',' Туалетная вода спрей', ' туалетная вода спрей',' Туалетная вода',' туалетная вода',' спрей',' туалетная',' Вода');
	    $value[0] = str_ireplace($patterns, "", $value[0]);
		$value[4] = 2;
	}
	elseif(stripos($value[0],' дезодорант') or stripos($value[0],' део'))
	{
		$value[4] = 4;
	}
	elseif(stripos($value[0],' шампунь гель'))
	{
		$patterns = ' для душа';
		$value[0] = str_ireplace($patterns, "", $value[0]);
		$value[4] = 10;
	}
	elseif(stripos($value[0],' гель для душа'))
	{
		$value[4] = 5;
	}
	elseif(stripos($value[0],' одеколон'))
	{
		$value[4] = 12;
	}
	elseif(stripos($value[0],' лосьон для тела'))
	{
		$value[4] = 7;
	}
	elseif(stripos($value[0],' лосьон после бритья'))
	{
		$value[4] = 8;
	}
	elseif(stripos($value[0],' бальзам после бритья'))
	{
		$value[4] = 9;
	}
	elseif(stripos($value[0],' набор'))
	{
		$value[4] = 3;
	}
	elseif(stripos($value[0],' крем для тела'))
	{
		$value[4] = 11;
	}
	
	if(stripos($value[0],' Ж '))
	{
		$value[0] = str_ireplace(" Ж", "", $value[0]);
		$value[5] = 1;
	}
	elseif(stripos($value[0],' М '))
	{
		$value[0] = str_ireplace(" М", "", $value[0]);
		$value[5] = 2;
	}
	elseif(stripos($value[0],' МЖ '))
	{
		$value[0] = str_ireplace(" МЖ", "", $value[0]);
		$value[5] = 4;
	}
	
	$value[0] = preg_replace("/ (\d+) мл/", " \$1ml", $value[0]);
	
	
	  
?>
    
  <tr>
    <td><b><?=$a?></b>&nbsp;&nbsp;&nbsp;</td>
    <td><?=$value[0]?></td>
    <td>&nbsp;&nbsp;&nbsp;тип <?=$value[4]?></td>
    <td>&nbsp;&nbsp;&nbsp;кат <?=$value[5]?></td>
    <td><?=$value[3]?></td>
    <td><? $cena_pr = $value[3]+($value[3]/100)*1.5; $cena_pr = ceil($cena_pr); echo $cena_pr; ?></td>
    <td><? $cena = $cena_pr/2+$cena_pr; $cena = ceil($cena/10) * 10; echo $cena; ?></td>
    <td><? $cena_b = $cena/8*10; $cena_b = ceil($cena_b/10) * 10; echo $cena_b; ?></td>
  </tr>
  
  <?
     $url = translit($value[0]);
     $value[0] = mysql_real_escape_string($value[0]);
     $str_tobd .= ($a==1) ? "('1','".$url."','".$value[5]."','".$brand."','".$value[4]."','".$value[0]."','".$value[0]."','".$value[0]."','".$value[0]."','".$value[0]."','','".$cena_b."','".$cena."','".$cena_pr."')" : ", ('1','".translit($value[0])."','".$value[5]."','".$brand."','".$value[4]."','".$value[0]."','".$value[0]."','".$value[0]."','".$value[0]."','".$value[0]."','','".$cena_b."','".$cena."','".$cena_pr."')";
  ?>
  
  <? $a++; else: ?>
  
  <tr>
    <td class="td"></td>
    <td class="td"></td>
    <td class="td"></td>
    <td class="td"></td>
    <td class="td"></td>
    <td class="td"></td>
    <td class="td"></td>
    <td class="td"></td>
  </tr>
  <tr>
    <td></td>
    <td><h4><?= mb_convert_encoding($value[0], 'UTF-8', 'Windows-1251');?></h4></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  
  <? endif; ?>
        
<? endforeach; 
   //$res = mysql_query("INSERT INTO Product (status,url,cat,brand,type,name,title,meta_d,meta_k,header,text,cena,s_cena,z_cena) VALUES ".$str_tobd."");
   //if(!$res) die(mysql_error());
}
catch (Exception $e) { //Если csv файл не существует, выводим сообщение
    echo "Ошибка: " . $e->getMessage();
}
?>
</table>

<? //echo $str_tobd; ?>


</body>
</html>