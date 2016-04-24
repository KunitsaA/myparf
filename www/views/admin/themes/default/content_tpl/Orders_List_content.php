<script>
            $(function() {
                $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd", dayNames: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"], dayNamesMin: ["Вс", "Пн","Вт","Ср", "Чт", "Пт", "Сб"], monthNames: ["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрьr","Октябрь","Ноябрь","Декабрь"], firstDay: 1 });
				
        });
		     $(function() {
                $( "#datepickers" ).datepicker({ dateFormat: "yy-mm-dd", dayNames: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"], dayNamesMin: ["Вс", "Пн","Вт","Ср", "Чт", "Пт", "Сб"], monthNames: ["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрьr","Октябрь","Ноябрь","Декабрь"], firstDay: 1 });
				
        });
</script>
<form action="admin.php?c=Orders_List" method="post" name="Orders_List">

<label for="status">Статус:</label>

<select name="status">
    <option value="all" <? if($_SESSION['ord_status']=='all') echo 'selected="selected"'; ?>>Все</option>
<? if(count($stat_L)>0): foreach($stat_L as $st): ?> 
    <option value="<?=$st['id']?>" <? if($_SESSION['ord_status']==$st['id']) echo 'selected="selected"'; ?>><?=$st['title']?></option>
<? endforeach; endif ?>
</select>

<label for="date_from" >Дата от:</label>&nbsp;&nbsp;<input id="datepicker" name="date_from" type="text" value="<?=$_SESSION['date_from']?>" class="styler" />&nbsp;&nbsp;<label for="date_to" >до:</label>&nbsp;&nbsp;<input id="datepickers" name="date_to" type="text" value="<?=$_SESSION['date_to']?>" class="styler" />

<button class="styler" type="submit" >Показать</button>

</form>

<form action="admin.php?c=Orders_List" method="post">
<style>
#Orders{
	
}
#Orders tr:first-child{
	background:#333;
	padding:5px;
	color:#FFF;
}
#Orders tr:hover:not(:first-child){
	background: #C1FFCE !important;
}
#Orders td{
	height:30px;
	padding:5px;
}
</style>
<table id="Orders" width="100%" border="0">
  <tr>
    <td align="center"><input type="checkbox" id="CheckAll" /></td>
    <td>id</td>
    <td>дата</td>
    <td>статус</td>
    <td>покупатель</td>
    <td>телефон</td>
    <td>город</td>
    <td>сумма</td>
    <td>детали</td>
  </tr>
  <? $a=0; if(count($data)>0): foreach($data as $d): ?>
  <tr style="background-color:<?=($a%2?"#EEE;":"#FFFFFF;")?>">
    <td align="center"><input name="id[]" type="checkbox" value="<?=$d['id']?>"></td>
    <td><?=$d['id']?></td>
    <td><? $d['date'] = explode('-',$d['date']); $d['date'] = array_reverse($d['date']); $d['date'] = implode('.',$d['date']); ?><?=$d['date']?></td>
    <td><?=$d['title']?></td>
    <td><?=$d['name']?>&nbsp;<?=$d['lastname']?></td>
    <td><?=$d['phone']?></td>
    <td><?=$d['city']?></td>
    <td><?=number_format($d['total'], 0, '.', ' ')?>&nbsp;руб</td>
    <td><a href="admin.php?c=Orders_Object&id=<?=$d['id']?>">перейти</a></td>
  </tr>
  <? $a++; endforeach; endif ?>
</table>

<button type="button" name="button" class="styler">Удалить выбранное</button>

</form>

      <? /**************************ПОСТРАНИЧНАЯ НАВИГАЦИЯ***********************/ ?>
      <? if ($pages>2): $ss = $page+1; $start = $ss-$limit; $end = $ss+$limit; ?>
      <div align="center" class="Page_navigation">
      <p>Страницы</p>
         <? for ($j = 1; $j<$pages; $j++) : ?>
           <? if ($j>=$start && $j<=$end) : ?>
                    <? if ($j==($page+1)) : ?>				         
                              <a class="this" href="<?=$uri?>&page=<?=$j?>"><?=$j?></a>
                    <? else : ?>
                              <a href="<?=$uri?>&page=<?=$j?>"><?=$j?></a>        
                    <? endif ?>
           <? else: ?>
                    <? if($pages>$limit && $j==($pages-1)) : ?>               
                              ... <a href="<?=$uri?>&page=<?=$j?>"><?=$j?></a>
                    <? elseif($pages>$limit && $j==1): ?>
                              <a href="<?=$uri?>&page=<?=$j?>"><?=$j?></a> ...
                    <? endif ?>
           <? endif ?>
         <? endfor ?>
      </div>
      <? endif ?>
      <? //**************************///ПОСТРАНИЧНАЯ НАВИГАЦИЯ***********************/ ?>
