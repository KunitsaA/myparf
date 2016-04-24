<a href="admin.php?c=Portfolio_Object">Добавить объект</a>

<form action="admin.php?c=Portfolio_List" method="post">

<table class="List"  border="0">
  <tr style="background-color:#EEE;">
    <td width="15"><input type="checkbox" onClick="Checkall(this.form);" /></td>
    <td>имя</td>
    <td width="40" align="center">статус</td>
    <td width="40" align="center">правка</td>
    <td width="40" align="center">удаление</td>
  </tr>
<? $a=0; foreach($data as $d): if($d['status']==1): $img_status = 'Ok_icon.png'; $title_status = 'Ok'; else: $img_status = 'Not_icon.png'; $title_status = 'Недоступно'; endif
//$img_status = ($d['status']==1) ? 'Ok_icon.png' : 'Not_icon.png'; ?>

  <tr style="background-color:<?=($a%2?"#EEE;":"#FFFFFF;")?>">
    <td align="center"><input name="id[]" type="checkbox" value="<?=$d['id']?>"></td>
    <td><?=$d['name']?></td>
    <td align="center"><a class="StatusLink" data-id="<?=$d['id']?>" data-status="<?=$d['status']?>" href="#"><img src="img/<?=$img_status?>" title="<?=$title_status?>" border="0" /></a></td>
    <td align="center"><a class="EditLink" href="admin.php?c=Portfolio_Object&id=<?=$d['id']?>"><img src="img/Edit_icon.png" title="Редактировать" border="0" /></a></td>
    <td align="center"><a class="DeleteLink" data-id="<?=$d['id']?>" href="#"><img src="img/Delete_icon.png" title="Удалить" border="0" /></a></td>
  </tr>

<? $a++; endforeach ?>

</table>

<button type="button" name="button" >удалить выбранное</button>

</form>