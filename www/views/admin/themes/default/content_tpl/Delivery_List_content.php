</div><div style="width:630px; margin:20px auto;">
<div class="add_link_wrap">
<a class="add_link" href="admin.php?c=Delivery_Object">Добавить способ доставки</a>
</div>

<form action="admin.php?c=Delivery_List" method="post">

<table class="List"  border="0">
  <tr>
    <td width="15"><input type="checkbox" id="CheckAll" /></td>
    <td>способ доставки</td>
    <td  align="center">статус</td>
    <td  align="center">правка</td>
    <td  align="center">x</td>
  </tr>
<? $a=0; foreach($data as $d): if($d['status']==1): $img_status = 'Ok_icon.png'; $title_status = 'Ok'; else: $img_status = 'Not_icon.png'; $title_status = 'Недоступно'; endif ?>

  <tr style="background-color:<?=($a%2?"#EEE;":"#FFFFFF;")?>">
    <td align="center"><input name="id[]" type="checkbox" value="<?=$d['id']?>"></td>
    <td><?=$d['name']?></td>
    <td align="center"><a class="StatusLink" data-id="<?=$d['id']?>" data-status="<?=$d['status']?>" href="#"><img src="img/<?=$img_status?>" title="<?=$title_status?>" border="0" height="25" /></a></td>
    <td align="center"><a class="EditLink" href="admin.php?c=Delivery_Object&id=<?=$d['id']?>"><img src="img/Edit_icon.png" title="Редактировать" border="0" height="25" /></a></td>
    <td align="center"><a class="DeleteLink" data-id="<?=$d['id']?>" href="#"><img src="img/Delete_icon.png" title="Удалить" border="0" height="25" /></a></td>
  </tr>

<? $a++; endforeach ?>

</table>

<button class="styler" type="button" name="button" >удалить выбранное</button>

</form>
</div>