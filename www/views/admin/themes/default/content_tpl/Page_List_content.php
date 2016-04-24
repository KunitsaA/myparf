<? if($set['new']==1): ?>
<a href="admin.php?c=Page_Object">Добавить страницу</a>
<? endif ?>

<form action="admin.php?c=Page_List" method="post">

<table class="List"  border="0">
  <tr>
    <td width="15"><input type="checkbox" id="CheckAll" /></td>
    <td>имя</td>
    <td width="40" align="center">статус</td>
    <td width="40" align="center">правка</td>
    <td width="40" align="center">удаление</td>
  </tr>
<? 
$a=0; foreach($data as $d): if($d['status']==1): $img_status = 'Ok_icon.png'; $title_status = 'Страница доступна'; else: $img_status = 'Not_icon.png'; $title_status = 'Страница скрыта'; endif;

if(isset($set['status_off']) && isset($set['delete_off'])){ $status_off = explode(',',$set['status_off']); $delete_off = explode(',',$set['delete_off']); }
?>

  <tr style="background-color:<?=($a%2?"#EEE;":"#FFFFFF;")?>">
    <td align="center">
    <? if(array_search($d['id'],$delete_off)===false): ?>
    <input name="id[]" type="checkbox" value="<?=$d['id']?>">
    <? endif ?>
    </td>
    <td><?=$d['name']?></td>
    <td align="center">
    <? if(array_search($d['id'],$status_off)===false): ?>
    <a class="StatusLink" data-id="<?=$d['id']?>" data-status="<?=$d['status']?>" href="#"><img src="img/<?=$img_status?>" title="<?=$title_status?>" border="0" /></a>
    <? else: ?>
    <img src="img/Ok_icon_disabled.png" title="<?=$title_status?>" border="0" />
    <? endif ?>
    </td>
    <td align="center"><a class="EditLink" href="admin.php?c=Page_Object&id=<?=$d['id']?>"><img src="img/Edit_icon.png" title="Редактировать" border="0" /></a></td>
    <td align="center">
    <? if(array_search($d['id'],$delete_off)===false): ?>
    <a class="DeleteLink" data-id="<?=$d['id']?>" href="#"><img src="img/Delete_icon.png" title="Удалить" border="0" /></a>
    <? else: ?>
    <img src="img/Delete_icon_disabled.png" title="Удалить" border="0" />
    <? endif ?>
    </td>
  </tr>

<? $a++; endforeach ?>

</table>

<button class="styler" type="button" name="button" >удалить выбранное</button>

</form>