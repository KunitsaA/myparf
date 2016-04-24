
<div style="width:350px; overflow:hidden; display:inline-block; vertical-align:top;">

  <div class="add_link_wrap">
  <? if(!$_GET['cat']): ?>
  <a class="add_link" href="admin.php?c=Product_Cat">Добавить категорию</a>
  <? else: ?>
      <? if(count($objects)==0): ?><a class="add_link" href="admin.php?c=Product_Cat&parent=<?=$_GET['cat']?>">Добавить категорию</a><? endif ?>
  <? endif ?>
  </div>
  <form action="admin.php?c=Product_List" method="post">
  
  <div id='cssmenu'>
  <?=$catalog?>
  </div>
  
  <button class="styler" type="button" name="button" >удалить выбранное</button>
  
  </form>
  
  <? if(count($objects)>0): ?>
	 <? /*================================БРЕНДЫ======================================*/ ?>
     <? if(count($brands)>0): ?>
     <div class="Brands">
        <? //echo '<pre>'; print_r($urb); echo '</pre>'; ?>
        <p><a href="<?=$uri?>">Все производители</a></p>
     <? foreach($brands as $br): ?>
        <p><a href="<?=$uri?>&brand=<?=$br['brand']?>"><?=$br['b_name']?></a> <span>(<?=$br['cid']?>)</span></p>
     <? endforeach ?>
     </div>
     <? endif ?>
     <? /*=============================///БРЕНДЫ======================================*/ ?>
  <? endif ?>


</div><div style="width:630px; overflow:hidden; display:inline-block;">
<div class="add_link_wrap">
<? if($_GET['cat']): ?><a class="add_link" href="admin.php?c=Product_Object&cat=<?=$_GET['cat']?>">Добавить товар</a><? endif ?>
</div>
<form action="admin.php?c=Product_List" method="post">

<table class="List"  border="0">
  <tr>
    <td width="15"><input type="checkbox" id="CheckAll" /></td>
    <td>товары</td>
    <td  align="center">статус</td>
    <td  align="center">правка</td>
    <td  align="center">x</td>
  </tr>
<? $a=0; foreach($objects as $d): if($d['status']==1): $img_status = 'Ok_icon.png'; $title_status = 'Ok'; else: $img_status = 'Not_icon.png'; $title_status = 'Недоступно'; endif
//$img_status = ($d['status']==1) ? 'Ok_icon.png' : 'Not_icon.png'; ?>

  <tr style="background-color:<?=($a%2?"#EEE;":"#FFFFFF;")?>">
    <td align="center"><input name="id[]" type="checkbox" value="<?=$d['id']?>"></td>
    <td><?=$d['name']?></td>
    <td align="center"><a class="StatusLink" data-id="<?=$d['id']?>" data-status="<?=$d['status']?>" href="#"><img src="img/<?=$img_status?>" title="<?=$title_status?>" border="0" height="25" /></a></td>
    <td align="center"><a class="EditLink" href="admin.php?c=Product_Object&id=<?=$d['id']?>"><img src="img/Edit_icon.png" title="Редактировать" border="0" height="25" /></a></td>
    <td align="center"><a class="DeleteLink" data-id="<?=$d['id']?>" href="#"><img src="img/Delete_icon.png" title="Удалить" border="0" height="25" /></a></td>
  </tr>

<? $a++; endforeach ?>

</table>

<button class="styler" type="button" name="button" >удалить выбранное</button>

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

</div>