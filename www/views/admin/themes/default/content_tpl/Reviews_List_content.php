<div style="width:90%; margin:20px auto;">
<div class="add_link_wrap">
<? if($_GET['show']): ?>
<a class="add_link" href="admin.php?c=Reviews_List">Новые отзывы</a>
<? else: ?>
<a class="add_link" href="admin.php?c=Reviews_List&show=all">Все отзывы</a>
<? endif ?>
</div>

<form action="admin.php?c=Reviews_List" method="post">

<table class="List"  border="0">
  <tr>
    <td width="15"><input type="checkbox" id="CheckAll" /></td>
    <td>товар</td>
    <td>отзыв</td>
    <td  align="center">статус</td>
    <td  align="center">правка</td>
  </tr>
<? $a=0; foreach($data as $d): if($d['status']==1): $img_status = 'Ok_icon.png'; $title_status = 'Ok'; else: $img_status = 'Not_icon.png'; $title_status = 'Недоступно'; endif
?>

  <tr style="background-color:<?=($a%2?"#EEE;":"#FFFFFF;")?>">
    <td align="center"><input name="id[]" type="checkbox" value="<?=$d['id']?>"></td>
    <td><?=$d['p_name']?></td>
    <td>
    <div class="Comment">
	<p class="name"><?=$d['name']?></p>
    <div class="rating"><? for($i=0;$i<$d['rating'];$i++): ?><img src="img/reting_star.jpg" width="20" height="20"><? endfor ?></div>
	<p><?=$d['text']?></p>
    </div>
    </td>
    <td align="center"><a class="StatusLink" data-id="<?=$d['id']?>" data-status="<?=$d['status']?>" href="#"><img src="img/<?=$img_status?>" title="<?=$title_status?>" border="0" height="25" /></a></td>
    <td align="center"><a class="DeleteLink" data-id="<?=$d['id']?>" href="#"><img src="img/Delete_icon.png" title="Удалить" border="0" height="25" /></a></td>
  </tr>

<? $a++; endforeach ?>

</table>

<button class="styler" type="button" name="button" >Удалить выбранное</button>

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